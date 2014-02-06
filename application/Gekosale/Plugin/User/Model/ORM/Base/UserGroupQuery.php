<?php

namespace Gekosale\Plugin\User\Model\ORM\Base;

use \Exception;
use \PDO;
use Gekosale\Plugin\Controller\Model\ORM\ControllerPermission;
use Gekosale\Plugin\User\Model\ORM\UserGroup as ChildUserGroup;
use Gekosale\Plugin\User\Model\ORM\UserGroupI18nQuery as ChildUserGroupI18nQuery;
use Gekosale\Plugin\User\Model\ORM\UserGroupQuery as ChildUserGroupQuery;
use Gekosale\Plugin\User\Model\ORM\Map\UserGroupTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user_group' table.
 *
 * 
 *
 * @method     ChildUserGroupQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUserGroupQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildUserGroupQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildUserGroupQuery groupById() Group by the id column
 * @method     ChildUserGroupQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildUserGroupQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildUserGroupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserGroupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserGroupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserGroupQuery leftJoinControllerPermission($relationAlias = null) Adds a LEFT JOIN clause to the query using the ControllerPermission relation
 * @method     ChildUserGroupQuery rightJoinControllerPermission($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ControllerPermission relation
 * @method     ChildUserGroupQuery innerJoinControllerPermission($relationAlias = null) Adds a INNER JOIN clause to the query using the ControllerPermission relation
 *
 * @method     ChildUserGroupQuery leftJoinUserGroupShop($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserGroupShop relation
 * @method     ChildUserGroupQuery rightJoinUserGroupShop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserGroupShop relation
 * @method     ChildUserGroupQuery innerJoinUserGroupShop($relationAlias = null) Adds a INNER JOIN clause to the query using the UserGroupShop relation
 *
 * @method     ChildUserGroupQuery leftJoinUserGroupUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserGroupUser relation
 * @method     ChildUserGroupQuery rightJoinUserGroupUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserGroupUser relation
 * @method     ChildUserGroupQuery innerJoinUserGroupUser($relationAlias = null) Adds a INNER JOIN clause to the query using the UserGroupUser relation
 *
 * @method     ChildUserGroupQuery leftJoinUserGroupI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserGroupI18n relation
 * @method     ChildUserGroupQuery rightJoinUserGroupI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserGroupI18n relation
 * @method     ChildUserGroupQuery innerJoinUserGroupI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the UserGroupI18n relation
 *
 * @method     ChildUserGroup findOne(ConnectionInterface $con = null) Return the first ChildUserGroup matching the query
 * @method     ChildUserGroup findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserGroup matching the query, or a new ChildUserGroup object populated from the query conditions when no match is found
 *
 * @method     ChildUserGroup findOneById(int $id) Return the first ChildUserGroup filtered by the id column
 * @method     ChildUserGroup findOneByCreatedAt(string $created_at) Return the first ChildUserGroup filtered by the created_at column
 * @method     ChildUserGroup findOneByUpdatedAt(string $updated_at) Return the first ChildUserGroup filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildUserGroup objects filtered by the id column
 * @method     array findByCreatedAt(string $created_at) Return ChildUserGroup objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildUserGroup objects filtered by the updated_at column
 *
 */
abstract class UserGroupQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Gekosale\Plugin\User\Model\ORM\Base\UserGroupQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Gekosale\\Plugin\\User\\Model\\ORM\\UserGroup', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserGroupQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserGroupQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Gekosale\Plugin\User\Model\ORM\UserGroupQuery) {
            return $criteria;
        }
        $query = new \Gekosale\Plugin\User\Model\ORM\UserGroupQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildUserGroup|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserGroupTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserGroupTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildUserGroup A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CREATED_AT, UPDATED_AT FROM user_group WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildUserGroup();
            $obj->hydrate($row);
            UserGroupTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildUserGroup|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserGroupTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserGroupTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UserGroupTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UserGroupTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserGroupTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UserGroupTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UserGroupTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserGroupTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(UserGroupTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(UserGroupTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserGroupTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Gekosale\Plugin\Controller\Model\ORM\ControllerPermission object
     *
     * @param \Gekosale\Plugin\Controller\Model\ORM\ControllerPermission|ObjectCollection $controllerPermission  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function filterByControllerPermission($controllerPermission, $comparison = null)
    {
        if ($controllerPermission instanceof \Gekosale\Plugin\Controller\Model\ORM\ControllerPermission) {
            return $this
                ->addUsingAlias(UserGroupTableMap::COL_ID, $controllerPermission->getUserGroupId(), $comparison);
        } elseif ($controllerPermission instanceof ObjectCollection) {
            return $this
                ->useControllerPermissionQuery()
                ->filterByPrimaryKeys($controllerPermission->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByControllerPermission() only accepts arguments of type \Gekosale\Plugin\Controller\Model\ORM\ControllerPermission or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ControllerPermission relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function joinControllerPermission($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ControllerPermission');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ControllerPermission');
        }

        return $this;
    }

    /**
     * Use the ControllerPermission relation ControllerPermission object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Gekosale\Plugin\Controller\Model\ORM\ControllerPermissionQuery A secondary query class using the current class as primary query
     */
    public function useControllerPermissionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinControllerPermission($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ControllerPermission', '\Gekosale\Plugin\Controller\Model\ORM\ControllerPermissionQuery');
    }

    /**
     * Filter the query by a related \Gekosale\Plugin\User\Model\ORM\UserGroupShop object
     *
     * @param \Gekosale\Plugin\User\Model\ORM\UserGroupShop|ObjectCollection $userGroupShop  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function filterByUserGroupShop($userGroupShop, $comparison = null)
    {
        if ($userGroupShop instanceof \Gekosale\Plugin\User\Model\ORM\UserGroupShop) {
            return $this
                ->addUsingAlias(UserGroupTableMap::COL_ID, $userGroupShop->getUserGroupId(), $comparison);
        } elseif ($userGroupShop instanceof ObjectCollection) {
            return $this
                ->useUserGroupShopQuery()
                ->filterByPrimaryKeys($userGroupShop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserGroupShop() only accepts arguments of type \Gekosale\Plugin\User\Model\ORM\UserGroupShop or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserGroupShop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function joinUserGroupShop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserGroupShop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserGroupShop');
        }

        return $this;
    }

    /**
     * Use the UserGroupShop relation UserGroupShop object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Gekosale\Plugin\User\Model\ORM\UserGroupShopQuery A secondary query class using the current class as primary query
     */
    public function useUserGroupShopQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserGroupShop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserGroupShop', '\Gekosale\Plugin\User\Model\ORM\UserGroupShopQuery');
    }

    /**
     * Filter the query by a related \Gekosale\Plugin\User\Model\ORM\UserGroupUser object
     *
     * @param \Gekosale\Plugin\User\Model\ORM\UserGroupUser|ObjectCollection $userGroupUser  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function filterByUserGroupUser($userGroupUser, $comparison = null)
    {
        if ($userGroupUser instanceof \Gekosale\Plugin\User\Model\ORM\UserGroupUser) {
            return $this
                ->addUsingAlias(UserGroupTableMap::COL_ID, $userGroupUser->getUserGroupId(), $comparison);
        } elseif ($userGroupUser instanceof ObjectCollection) {
            return $this
                ->useUserGroupUserQuery()
                ->filterByPrimaryKeys($userGroupUser->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserGroupUser() only accepts arguments of type \Gekosale\Plugin\User\Model\ORM\UserGroupUser or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserGroupUser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function joinUserGroupUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserGroupUser');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserGroupUser');
        }

        return $this;
    }

    /**
     * Use the UserGroupUser relation UserGroupUser object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Gekosale\Plugin\User\Model\ORM\UserGroupUserQuery A secondary query class using the current class as primary query
     */
    public function useUserGroupUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserGroupUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserGroupUser', '\Gekosale\Plugin\User\Model\ORM\UserGroupUserQuery');
    }

    /**
     * Filter the query by a related \Gekosale\Plugin\User\Model\ORM\UserGroupI18n object
     *
     * @param \Gekosale\Plugin\User\Model\ORM\UserGroupI18n|ObjectCollection $userGroupI18n  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function filterByUserGroupI18n($userGroupI18n, $comparison = null)
    {
        if ($userGroupI18n instanceof \Gekosale\Plugin\User\Model\ORM\UserGroupI18n) {
            return $this
                ->addUsingAlias(UserGroupTableMap::COL_ID, $userGroupI18n->getId(), $comparison);
        } elseif ($userGroupI18n instanceof ObjectCollection) {
            return $this
                ->useUserGroupI18nQuery()
                ->filterByPrimaryKeys($userGroupI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserGroupI18n() only accepts arguments of type \Gekosale\Plugin\User\Model\ORM\UserGroupI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserGroupI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function joinUserGroupI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserGroupI18n');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserGroupI18n');
        }

        return $this;
    }

    /**
     * Use the UserGroupI18n relation UserGroupI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Gekosale\Plugin\User\Model\ORM\UserGroupI18nQuery A secondary query class using the current class as primary query
     */
    public function useUserGroupI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinUserGroupI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserGroupI18n', '\Gekosale\Plugin\User\Model\ORM\UserGroupI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUserGroup $userGroup Object to remove from the list of results
     *
     * @return ChildUserGroupQuery The current query, for fluid interface
     */
    public function prune($userGroup = null)
    {
        if ($userGroup) {
            $this->addUsingAlias(UserGroupTableMap::COL_ID, $userGroup->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_group table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserGroupTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserGroupTableMap::clearInstancePool();
            UserGroupTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildUserGroup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildUserGroup object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserGroupTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserGroupTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        UserGroupTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            UserGroupTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // i18n behavior
    
    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildUserGroupQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'UserGroupI18n';
    
        return $this
            ->joinUserGroupI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }
    
    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildUserGroupQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'en_US', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('UserGroupI18n');
        $this->with['UserGroupI18n']->setIsWithOneToMany(false);
    
        return $this;
    }
    
    /**
     * Use the I18n relation query object
     *
     * @see       useQuery()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildUserGroupI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserGroupI18n', '\Gekosale\Plugin\User\Model\ORM\UserGroupI18nQuery');
    }

    // timestampable behavior
    
    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildUserGroupQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(UserGroupTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildUserGroupQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(UserGroupTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     ChildUserGroupQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserGroupTableMap::COL_UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     ChildUserGroupQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserGroupTableMap::COL_UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     ChildUserGroupQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserGroupTableMap::COL_CREATED_AT);
    }
    
    /**
     * Order by create date asc
     *
     * @return     ChildUserGroupQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserGroupTableMap::COL_CREATED_AT);
    }

} // UserGroupQuery