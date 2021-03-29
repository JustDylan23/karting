<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserAdmin extends AbstractAdmin
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $entityManager;

    public function __construct($code, $class, $baseControllerName, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('username')
            ->add('email')
            ->add('initials')
            ->add('insertion')
            ->add('lastName')
            ->add('address')
            ->add('postalCode')
            ->add('city')
            ->add('phoneNumber')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('username')
            ->add('email')
            ->add('initials')
            ->add('insertion')
            ->add('lastName')
            ->add('address')
            ->add('postalCode')
            ->add('city')
            ->add('phoneNumber')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('username')
            ->add('email')
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => false,
                'first_options' => [
                    'label' => 'Password',
                ],
                'second_options' => ['label' => 'Repeat password'],
            ])
            ->add('initials')
            ->add('insertion')
            ->add('lastName')
            ->add('address')
            ->add('postalCode')
            ->add('city')
            ->add('phoneNumber')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('username')
            ->add('email')
            ->add('roles')
            ->add('initials')
            ->add('insertion')
            ->add('lastName')
            ->add('address')
            ->add('postalCode')
            ->add('city')
            ->add('phoneNumber')
            ->add('activities')
        ;
    }

    public function prePersist($object): void
    {
        parent::prePersist($object);
        $this->updateUser($object);
    }

    public function preUpdate($object): void
    {
        parent::preUpdate($object);
        $this->updateUser($object);
    }

    public function updateUser(User $user): void
    {
        if ($user->plainPassword) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->plainPassword));
            $this->entityManager->flush();
        }
    }
}
