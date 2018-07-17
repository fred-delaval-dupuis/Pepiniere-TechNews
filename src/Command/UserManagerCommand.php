<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 17/07/2018
 * Time: 14:08
 */

namespace App\Command;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserManagerCommand extends Command
{
    private $io;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    private $roles;

    /**
     * @inheritDoc
     */
    public function __construct(EntityManagerInterface $em, $roles, $name = null)
    {
        $this->em = $em;
        $this->roles = array_reverse($roles);
        parent::__construct($name);
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:user-manager')

            // the short description shown while running "php bin/console list"
            ->setDescription('Gestion de nos utilisateurs.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Cette commande permet de voir la lsite des utilisateurs et de leur attribuer des rôles...')
        ;
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);

        $this->io->title('Bienvenue dans le gestionnaire des utilisateurs');

//        $output->writeln("<error>ID utilisateur introuvable</error>");
//        $this->io->error('ID utilisateur introuvable');
//        $this->io->section('Lorem Ipsum Dolor Sit Amet');
//        $this->io->note('Lorem Ipsum Dolor Sit Amet');
//        $this->io->caution('Lorem Ipsum Dolor Sit Amet');
//        $this->io->success('Lorem Ipsum Dolor Sit Amet');
//        $this->io->warning('Lorem Ipsum Dolor Sit Amet');

//        $this->io->table(
//            ['Header #1', 'Header #2'],
//            [
//                ['Cell 1-1', 'Cell-1-2'],
//                ['Cell 2-1', 'Cell-2-2'],
//                ['Cell 3-1', 'Cell-3-2'],
//            ]
//        );

//        $this->io->choice('Quelle est la couleur du cheval blanc de Henri IV ?', ['bleu', 'vert', 'blanc'], 'bleu');

        $action = $this->io->choice('Que souhaitez-vous faire ?', ['Afficher la liste des utilisateurs', 'Ajouter un Rôle à un utilisateur', 'Supprimer un rôle à un utilisateur'], 'Afficher la liste des utilisateurs');

        switch ($action) {
            case 'Afficher la liste des utilisateurs':
                $this->listUsers();
                break;
            case 'Ajouter un Rôle à un utilisateur':
                $this->addUserRole();
                break;
            case 'Supprimer un rôle à un utilisateur':
                $this->deleteUserRole();
                break;
            default:
        }
    }

    private function listUsers()
    {
        $this->io->section('Affichage des utilisateurs');
        $tabUsers = [];
        $users = $this->em->getRepository(User::class)->findAll();

        /* @var User $user */
        foreach ($users as $user) {
            $tabUsers[] = [
                $user->getId(),
                $user->getLastName() . ' ' . $user->getFirstName(),
                $user->getEmail(),
                implode(', ', $user->getRoles()),
                (null === $user->getLastConnectionDate()) ? '' : $user->getLastConnectionDate()->format('d-M-Y')
            ];
        }

        $this->io->table(
            ['# id', 'Full Name', 'E-mail', 'Roles', 'Last Connection'],
            $tabUsers
        );
    }

    private function addUserRole()
    {
        $this->io->section('Ajouter un rôle à un utilisateur');
        $id = $this->io->ask('Id de l\'utilisateur');

//            $role = $this->io->choice('Rôle de l\'utilisateur', ['ROLE_AUTHOR', 'ROLE_EDITOR', 'ROLE_CORRECTOR', 'ROLE_PUBLISHER', 'ROLE_ADMIN'], 'ROLE_AUTHOR');
        $user = $this->em->getRepository(User::class)->find($id);
        $role = $this->io->choice('Rôle de l\'utilisateur', array_diff(array_reverse(array_keys($this->roles)), $user->getRoles()));

        if (null !== $user) {
            if ( ! in_array($role, $user->getRoles(), true)) {

                $confirm = $this->io->confirm('Etes-vous sûr(e) de vouloir ajouter le rôle ' . $role . ' à l\'utilisateur ' . $user->getFirstName() . ' ' . $user->getLastName(), false);

                if ($confirm) {
                    $user->setRoles(array_merge($user->getRoles(), [$role]));
                    $this->em->flush();
                    $this->io->success('Le rôle ' . $role . ' a bien été attribué à l\'utilisateur ' . $user->getFirstName() . ' ' . $user->getLastName());
                }

            } else {
                $this->io->error('L\'utilisateur ' . $user->getFirstName() . ' ' . $user->getLastName() . ' possède déjà le rôle ' . $role);
            }
        } else {
            $this->io->error('L\'utilisateur #' . $id . ' n\'existe pas.');
        }
    }

    private function deleteUserRole()
    {
        $this->io->section('Supprimer un rôle à un utilisateur');
        $id = $this->io->ask('Id de l\'utilisateur');

        $user = $this->em->getRepository(User::class)->find($id);

        if (null !== $user) {
            $role = $this->io->choice('Rôle de l\'utilisateur à supprimer', $user->getRoles(), $user->getRoles()[0]);
            if ( ! in_array($role, $user->getRoles())) {
                $this->io->error('L\'utilisateur ' . $user->getFirstName() . ' ' . $user->getLastName() . ' ne possède pas le rôle ' . $role);
            } else {
                $confirm = $this->io->confirm('Etes-vous sûr(e) de vouloir enlever le rôle ' . $role . ' à l\'utilisateur ' . $user->getFirstName() . ' ' . $user->getLastName(), false);

                if ($confirm) {
                    $user->setRoles(array_diff($user->getRoles(), [$role]));
                    $this->em->flush();
                    $this->io->success('Le rôle ' . $role . ' a bien été enlevé à l\'utilisateur ' . $user->getFirstName() . ' ' . $user->getLastName());
                }
            }
        } else {
            $this->io->error('L\'utilisateur #' . $id . ' n\'existe pas.');
        }
    }
}