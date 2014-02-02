<?php

namespace Gekosale\Plugin\Vat\Model\ORM\Base;

use \Exception;
use \PDO;
use Gekosale\Plugin\Vat\Model\ORM\Vat as ChildVat;
use Gekosale\Plugin\Vat\Model\ORM\VatQuery as ChildVatQuery;
use Gekosale\Plugin\Vat\Model\ORM\Map\VatTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'vat' table.
 *
 * 
 *
 * @method     ChildVatQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildVatQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildVatQuery orderByAddDate($order = Criteria::ASC) Order by the add_date column
 *
 * @method     ChildVatQuery groupById() Group by the id column
 * @method     ChildVatQuery groupByValue() Group by the value column
 * @method     ChildVatQuery groupByAddDate() Group by the add_date column
 *
 * @method     ChildVatQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVatQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVatQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVatQuery leftJoinVatTranslation($relationAlias = null) Adds a LEFT JOIN clause to the query using the VatTranslation relation
 * @method     ChildVatQuery rightJoinVatTranslation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the VatTranslation relation
 * @method     ChildVatQuery innerJoinVatTranslation($relationAlias = null) Adds a INNER JOIN clause to the query using the VatTranslation relation
 *
 * @method     ChildVat findOne(ConnectionInterface $con = null) Return the first ChildVat matching the query
 * @method     ChildVat findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVat matching the query, or a new ChildVat object populated from the query conditions when no match is found
 *
 * @method     ChildVat findOneById(int $id) Return the first ChildVat filtered by the id column
 * @method     ChildVat findOneByValue(string $value) Return the first ChildVat filtered by the value column
 * @method     ChildVat findOneByAddDate(string $add_date) Return the first ChildVat filtered by the add_date column
 *
 * @method     array findById(int $id) Return ChildVat objects filtered by the id column
 * @method     array findByValue(string $value) Return ChildVat objects filtered by the value column
 * @method     array findByAddDate(string $add_date) Return ChildVat objects filtered by the add_date column
 *
 */
abstract class VatQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Gekosale\Plugin\Vat\Model\ORM\Base\VatQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Gekosale\\Plugin\\Vat\\Model\\ORM\\Vat', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVatQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVatQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Gekosale\Plugin\Vat\Model\ORM\VatQuery) {
            return $criteria;
        }
        $query = new \Gekosale\Plugin\Vat\Model\ORM\VatQuery();
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
     * @return ChildVat|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = VatTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VatTableMap::DATABASE_NAME);
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
     * @return   ChildVat A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, VALUE, ADD_DATE FROM vat WHERE ID = :p0';
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
            $obj = new ChildVat();
            $obj->hydrate($row);
            VatTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildVat|array|mixed the result, formatted by the current formatter
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
     * @return ChildVatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VatTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildVatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VatTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildVatQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VatTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VatTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VatTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue(1234); // WHERE value = 1234
     * $query->filterByValue(array(12, 34)); // WHERE value IN (12, 34)
     * $query->filterByValue(array('min' => 12)); // WHERE value > 12
     * </code>
     *
     * @param     mixed $value The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVatQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(VatTableMap::VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(VatTableMap::VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VatTableMap::VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the add_date column
     *
     * Example usage:
     * <code>
     * $query->filterByAddDate('2011-03-14'); // WHERE add_date = '2011-03-14'
     * $query->filterByAddDate('now'); // WHERE add_date = '2011-03-14'
     * $query->filterByAddDate(array('max' => 'yesterday')); // WHERE add_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $addDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVatQuery The current query, for fluid interface
     */
    public function filterByAddDate($addDate = null, $comparison = null)
    {
        if (is_array($addDate)) {
            $useMinMax = false;
            if (isset($addDate['min'])) {
                $this->addUsingAlias(VatTableMap::ADD_DATE, $addDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($addDate['max'])) {
                $this->addUsingAlias(VatTableMap::ADD_DATE, $addDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VatTableMap::ADD_DATE, $addDate, $comparison);
    }

    /**
     * Filter the query by a related \Gekosale\Plugin\Vat\Model\ORM\VatTranslation object
     *
     * @param \Gekosale\Plugin\Vat\Model\ORM\VatTranslation|ObjectCollection $vatTranslation  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVatQuery The current query, for fluid interface
     */
    public function filterByVatTranslation($vatTranslation, $comparison = null)
    {
        if ($vatTranslation instanceof \Gekosale\Plugin\Vat\Model\ORM\VatTranslation) {
            return $this
                ->addUsingAlias(VatTableMap::ID, $vatTranslation->getVatId(), $comparison);
        } elseif ($vatTranslation instanceof ObjectCollection) {
            return $this
                ->useVatTranslationQuery()
                ->filterByPrimaryKeys($vatTranslation->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByVatTranslation() only accepts arguments of type \Gekosale\Plugin\Vat\Model\ORM\VatTranslation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the VatTranslation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildVatQuery The current query, for fluid interface
     */
    public function joinVatTranslation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('VatTranslation');

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
            $this->addJoinObject($join, 'VatTranslation');
        }

        return $this;
    }

    /**
     * Use the VatTranslation relation VatTranslation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Gekosale\Plugin\Vat\Model\ORM\VatTranslationQuery A secondary query class using the current class as primary query
     */
    public function useVatTranslationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinVatTranslation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'VatTranslation', '\Gekosale\Plugin\Vat\Model\ORM\VatTranslationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildVat $vat Object to remove from the list of results
     *
     * @return ChildVatQuery The current query, for fluid interface
     */
    public function prune($vat = null)
    {
        if ($vat) {
            $this->addUsingAlias(VatTableMap::ID, $vat->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the vat table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VatTableMap::DATABASE_NAME);
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
            VatTableMap::clearInstancePool();
            VatTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildVat or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildVat object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(VatTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VatTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        VatTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            VatTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // VatQuery