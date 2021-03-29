<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\DateTimeRangeFilter;
use Sonata\Form\Type\DateTimeRangePickerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

final class ActivityAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('datetime', DateTimeRangeFilter::class, ['field_type' => DateTimeRangePickerType::class]);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('datetime')
            ->add('activityType')
            ->add('totalUsers')
            ->add('_action', null, [
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
            ->add('datetime', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('maxRegistrations')
            ->add('users', ModelAutocompleteType::class, [
                'property' => 'username',
                'multiple' => true,
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('datetime')
        ;
    }
}
