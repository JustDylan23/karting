<?php

namespace App\Validator;

use App\Entity\Interfaces\MaxCountInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MaxCountValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint MaxCount */

        if (null === $value || '' === $value) {
            return;
        }

        if (!$value instanceof Collection) {
            $this->context->buildViolation('Value is not an instance of "'.Collection::class.'"')->addViolation();
            return;
        }

        $object = $this->context->getObject();
        if ($object instanceof MaxCountInterface && count($value) > $object->getMaxCount()) {
            $this->context->buildViolation($constraint->maxMessage)
                          ->setParameter('{{ limit }}', $object->getMaxCount())
                          ->addViolation();
        }
    }
}
