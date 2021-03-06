<?php

namespace Zcomdezign\PlatformBundle\Repository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{
    public function classicFind()
	{
		$qb =  $this->createQueryBuilder('a')->orderBy('a.id', 'DESC');
		return $qb
            ->getQuery()
            ->getResult()
		;
	}

	public function complexFind($content)
	{
		$qb =  $this->createQueryBuilder('a');

		// transforme les caractères spéciaux (accents etc) en caractères html
		$content = htmlentities($content);
		
		$words = explode(" ", $content);

		$request = 'a.content LIKE :word OR a.title LIKE :word';

		for($i = 1; $i < count($words); ++$i) {
            
			$request = $request . ' OR a.content LIKE :word' . $i . ' OR a.title LIKE :word' . $i;
            
		}
  		
		$qb
            ->where($request)
            ->setParameter('word', "%$words[0]%")
		;

		for($i = 1; $i < count($words); ++$i) {

			$qb
                ->setParameter('word'. $i, "%$words[$i]%")
			;
			
		}

		return $qb
            ->getQuery()
            ->getResult()
		;
	}
}