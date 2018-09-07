<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 30/10/2017
 * Time: 01:16 PM
 */

namespace ProgramacionBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Hosp\lecturaBundle\Entity\Empresa;
use ProgramacionBundle\Entity\Particular;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToPacienteTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($particular)
    {
        if (null === $particular) {
            return '';
        }

        return $paciente->getId().'/'.$paciente->getNombreCompleto();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $issueNumber
     * @return Issue|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($string)
    {
        $string=explode('/',$string);
        // no issue number? It's optional, so that's ok
        if (!$string[0]) {
            return;
        }


        $paciente = $this->em
            ->getRepository('SolicitudBundle:Paciente')
            // query for the issue with this id
            ->findOneById()($string[0])
        ;


        if (null === $paciente) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'No existe paciente con este id !',
                $string[0]
            ));
        }

        return $paciente;
    }
}