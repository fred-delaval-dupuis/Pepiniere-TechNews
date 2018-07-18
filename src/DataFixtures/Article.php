<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Article extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $articles = [
            [
                'title'         => 'Tip Aligning Digital Marketing with Business Goals and Objectives',
                'content'       => "<p> <span class=\"dropcap \">N</span>ulla quis lorem ut libero malesuada feugiat. Cras ultricies ligula sed magna dictum porta. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Sed porttitor lectus nibh.</p><p>Quisque velit nisi, pretium ut lacinia in, elementum id enim. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Pellentesque in ipsum id orci porta dapibus.</p><div class=\"post-detail-img\"><img alt=\"\" src=\"http://localhost:8000/images/product/4.jpg\" /></div><p class=\"quote\">Sed porttitor lectus nibh. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Quisque velit nisi, pretium ut lacinia in, elementum id enim.</p><p>Curabitur aliquet quam id dui posuere blandit. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</p>",
                'image'         => '3.jpg',
                'special'       => 0,
                'spotlight'     => 1,
                'category'      => $this->getReference('category1'),
                'author'        => $this->getReference('user1'),
            ],
            [
                'title'         => 'Six big ways MacOS Sierra is going to change your Apple experience',
                'content'       => "<p> <span class=\"dropcap \">N</span>ulla quis lorem ut libero malesuada feugiat. Cras ultricies ligula sed magna dictum porta. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Sed porttitor lectus nibh.</p><p>Quisque velit nisi, pretium ut lacinia in, elementum id enim. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Pellentesque in ipsum id orci porta dapibus.</p><div class=\"post-detail-img\"><img alt=\"\" src=\"http://localhost:8000/images/product/4.jpg\" /></div><p class=\"quote\">Sed porttitor lectus nibh. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Quisque velit nisi, pretium ut lacinia in, elementum id enim.</p><p>Curabitur aliquet quam id dui posuere blandit. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</p>",
                'image'         => '4.jpg',
                'special'       => 0,
                'spotlight'     => 0,
                'category'      => $this->getReference('category2'),
                'author'        => $this->getReference('user2'),

            ],
            [
                'title'         => 'Will Anker be the company to finally put a heads-up display in my car',
                'content'       => "<p> <span class=\"dropcap \">N</span>ulla quis lorem ut libero malesuada feugiat. Cras ultricies ligula sed magna dictum porta. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Sed porttitor lectus nibh.</p><p>Quisque velit nisi, pretium ut lacinia in, elementum id enim. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Pellentesque in ipsum id orci porta dapibus.</p><div class=\"post-detail-img\"><img alt=\"\" src=\"http://localhost:8000/images/product/4.jpg\" /></div><p class=\"quote\">Sed porttitor lectus nibh. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Quisque velit nisi, pretium ut lacinia in, elementum id enim.</p><p>Curabitur aliquet quam id dui posuere blandit. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</p>",
                'image'         => '5.jpg',
                'special'       => 1,
                'spotlight'     => 0,
                'category'      => $this->getReference('category1'),
                'author'        => $this->getReference('user2'),
            ],
            [
                'title'         => 'Windows 10 Now Running on 400 Million Active Devices, Says Microsoft',
                'content'       => "<p><span class=\"dropcap\">N</span>ulla quis lorem ut libero malesuada feugiat. Cras ultricies ligula sed magna dictum porta. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Sed porttitor lectus nibh.</p><p>Quisque velit nisi, pretium ut lacinia in, elementum id enim. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Pellentesque in ipsum id orci porta dapibus.</p><div class=\"post - detail - img\"><img alt=\"\" src=\"http://localhost:8000/images/product/4.jpg\" /></div><p class=\"quote\">Sed porttitor lectus nibh. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Quisque velit nisi, pretium ut lacinia in, elementum id enim.</p><p>Curabitur aliquet quam id dui posuere blandit. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</p>",
                'image'         => '1.jpg',
                'special'       => 0,
                'spotlight'     => 0,
                'category'      => $this->getReference('category2'),
                'author'        => $this->getReference('user1'),
            ],
            [
                'title'         => '400 million machines are now running Windows 10',
                'content'       => "<p><span class=\"dropcap \">N</span>ulla quis lorem ut libero malesuada feugiat. Cras ultricies ligula sed magna dictum porta. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Sed porttitor lectus nibh.</p><p>Quisque velit nisi, pretium ut lacinia in, elementum id enim. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Pellentesque in ipsum id orci porta dapibus.</p><div class=\"post-detail-img\"><img alt=\"\" src=\"http://localhost:8000/images/product/4.jpg\" /></div><p class=\"quote\">Sed porttitor lectus nibh. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Quisque velit nisi, pretium ut lacinia in, elementum id enim.</p><p>Curabitur aliquet quam id dui posuere blandit. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</p>",
                'image'         => '7.jpg',
                'special'       => 0,
                'spotlight'     => 1,
                'category'      => $this->getReference('category2'),
                'author'        => $this->getReference('user1'),
            ],
            [
                'title'         => '7 essential lessons from agency marketing to startup growth',
                'content'       => "<p><span class=\"dropcap \">N</span>ulla quis lorem ut libero malesuada feugiat. Cras ultricies ligula sed magna dictum porta. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Sed porttitor lectus nibh.</p><p>Quisque velit nisi, pretium ut lacinia in, elementum id enim. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Pellentesque in ipsum id orci porta dapibus.</p><div class=\"post-detail-img\"><img alt=\"\" src=\"http://localhost:8000/images/product/4.jpg\" /></div><p class=\"quote\">Sed porttitor lectus nibh. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Quisque velit nisi, pretium ut lacinia in, elementum id enim.</p><p>Curabitur aliquet quam id dui posuere blandit. Sed porttitor lectus nibh. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</p>",
                'image'         => '6.jpg',
                'special'       => 0,
                'spotlight'     => 0,
                'category'      => $this->getReference('category1'),
                'author'        => $this->getReference('user2'),
            ],
        ];

        foreach ($articles as $article) {
            $a = new \App\Entity\Article();
            $a->setTitle($article['title']);
            $a->setContent($article['content']);
            $a->setFeaturedImage($article['image']);
            $a->setSpecial($article['special']);
            $a->setSpotlight($article['spotlight']);
            $a->setCategory($article['category']);
            $a->setAuthor($article['author']);

            $manager->persist($a);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
