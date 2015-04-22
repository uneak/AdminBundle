<?php

	namespace Uneak\AdminBundle\Helper;

	use Doctrine\ORM\Query\Expr;

	class GridHelper {
		protected $em;

		public function __construct($em) {
			$this->em = $em;
		}


		public function getGridData($entityClass, $params) {

			$data = $this->gridFields($entityClass, $params);
			$recordsFiltered = $this->gridFieldsCount($entityClass, $params);
			$recordsTotal = $this->gridFieldsTotalCount($entityClass);

			return array(
				"data" => $data,
				"recordsFiltered" => $recordsFiltered,
				"recordsTotal" => $recordsTotal
			);

		}



		public function gridFieldsTotalCount($entityClass) {

			$qb = $this->em->createQueryBuilder();
			$qb
				->select('COUNT(o)')
				->from($entityClass, 'o');

			return $qb->getQuery()->getSingleScalarResult();
		}


		public function gridFieldsCount($qb) {
			$qb->select('COUNT(o)');
			return $qb->getQuery()->getSingleScalarResult();
		}

		public function gridFields($qb, $params) {

			$select = array();

			$select[] = 'o.id as DT_RowId';

			foreach ($params['columns'] as $columns) {
				if ($columns['data'] && substr($columns['data'], 0, 1) != '_') {
					$select[] = 'o.' . $columns['data'] . ' as ' . $columns['data'];
				}
			}

			$qb->select(implode(", ", $select));



			foreach ($params['order'] as $order) {

				if (substr($params['columns'][$order['column']]['data'], 0, 1) != '_') {
					$orderColName = 'o.' . $params['columns'][$order['column']]['data'];
					$qb->addOrderBy($orderColName, $order['dir']);
				}

			}

			$qb
				->setFirstResult($params['start'])
				->setMaxResults($params['length']);

			return $qb->getQuery()->getArrayResult();
		}

		public function createGridQueryBuilder($entityClass, $params) {


			$qb = $this->em->createQueryBuilder();
			$qb
				->from($entityClass, 'o');

			$searches = array();
			if (isset($params['search']['value'])) {
				$searches = explode(" ", trim($params['search']['value']));
				for ($index = 0; $index < count($searches); $index++) {
					$qb->setParameter('main_search_' . $index, '%' . $searches[$index] . '%');
				}
			}

			$fieldsSearch = new Expr\Andx();
			$globalSearch = new Expr\Orx();

			if (isset($params['columns'])) {
				foreach ($params['columns'] as $columns) {
					if ($columns['data'] && substr($columns['data'], 0, 1) != '_') {
						for ($index = 0; $index < count($searches); $index++) {
							$globalSearch->add($qb->expr()->like('o.' . $columns['data'], ':main_search_' . $index));
						}
						if ($columns['search']['value']) {
							$fieldsSearch->add($qb->expr()->like('o.' . $columns['data'], ':' . $columns['data'] . '_search'));
							$qb->setParameter($columns['data'] . '_search', '%' . $columns['search']['value'] . '%');
						}
					}
				}
			}

			$searchWhere = new Expr\Andx();
			if (isset($fieldsSearch)) {
				$searchWhere->add($fieldsSearch);
			}
			if (isset($globalSearch)) {
				$searchWhere->add($globalSearch);
			}

			if ($searchWhere->count()) {
				$qb->andWhere($searchWhere);
			}

			return $qb;
		}

	}
