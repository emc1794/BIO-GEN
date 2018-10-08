<?php

namespace ReparacionBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * SolicitudRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SolicitudRepository extends \Doctrine\ORM\EntityRepository
{
	public function listadoAjax($cantidad,$comienza,$campo,$dir,$buscar)
    {
        $em = $this->getEntityManager();
        $consul = $em->createQuery('SELECT s FROM ReparacionBundle:Solicitud s inner join s.cliente c
        WHERE c.paterno LIKE :value
        ORDER BY '.$campo.' '.$dir)
            ->setParameter('value',$buscar.'%')
            ->setFirstResult($comienza)
            ->setMaxResults($cantidad);

        $paginator = new Paginator($consul, $fetchJoinCollection = true);
        $c = count($paginator);
        $resp = $consul->getResult();
        return array('result'=>$resp,'cant'=>$c);
    }

    public function findReportePorFechas($inicio,$fin){
        $em = $this->getEntityManager();

        $resultado=$em->createQuery('SELECT d FROM ReparacionBundle:DetalleSolicitud d
                                    inner join d.solicitud s
                                    where s.fechaRegistro>=:inicio and s.fechaRegistro<=:fin
                                    ORDER BY s.fechaRegistro ASC')
                                    ->setParameter('inicio',$inicio)
                                    ->setParameter('fin',$fin)
                                    ->getResult();

        return $resultado;
    }
}