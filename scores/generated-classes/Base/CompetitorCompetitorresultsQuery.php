<?php

namespace Base;

use \CompetitorCompetitorresults as ChildCompetitorCompetitorresults;
use \CompetitorCompetitorresultsQuery as ChildCompetitorCompetitorresultsQuery;
use \Exception;
use \PDO;
use Map\CompetitorCompetitorresultsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'competitor_competitorresults' table.
 *
 *
 *
 * @method     ChildCompetitorCompetitorresultsQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildCompetitorCompetitorresultsQuery orderByCompetitorId($order = Criteria::ASC) Order by the competitor_ID column
 * @method     ChildCompetitorCompetitorresultsQuery orderByCompetitorresults($order = Criteria::ASC) Order by the COMPETITORRESULTS column
 * @method     ChildCompetitorCompetitorresultsQuery orderByCompetitorresultsKey($order = Criteria::ASC) Order by the COMPETITORRESULTS_KEY column
 *
 * @method     ChildCompetitorCompetitorresultsQuery groupById() Group by the ID column
 * @method     ChildCompetitorCompetitorresultsQuery groupByCompetitorId() Group by the competitor_ID column
 * @method     ChildCompetitorCompetitorresultsQuery groupByCompetitorresults() Group by the COMPETITORRESULTS column
 * @method     ChildCompetitorCompetitorresultsQuery groupByCompetitorresultsKey() Group by the COMPETITORRESULTS_KEY column
 *
 * @method     ChildCompetitorCompetitorresultsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCompetitorCompetitorresultsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCompetitorCompetitorresultsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCompetitorCompetitorresultsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCompetitorCompetitorresultsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCompetitorCompetitorresultsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCompetitorCompetitorresultsQuery leftJoinCompetitor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Competitor relation
 * @method     ChildCompetitorCompetitorresultsQuery rightJoinCompetitor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Competitor relation
 * @method     ChildCompetitorCompetitorresultsQuery innerJoinCompetitor($relationAlias = null) Adds a INNER JOIN clause to the query using the Competitor relation
 *
 * @method     ChildCompetitorCompetitorresultsQuery joinWithCompetitor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Competitor relation
 *
 * @method     ChildCompetitorCompetitorresultsQuery leftJoinWithCompetitor() Adds a LEFT JOIN clause and with to the query using the Competitor relation
 * @method     ChildCompetitorCompetitorresultsQuery rightJoinWithCompetitor() Adds a RIGHT JOIN clause and with to the query using the Competitor relation
 * @method     ChildCompetitorCompetitorresultsQuery innerJoinWithCompetitor() Adds a INNER JOIN clause and with to the query using the Competitor relation
 *
 * @method     \CompetitorQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCompetitorCompetitorresults findOne(ConnectionInterface $con = null) Return the first ChildCompetitorCompetitorresults matching the query
 * @method     ChildCompetitorCompetitorresults findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCompetitorCompetitorresults matching the query, or a new ChildCompetitorCompetitorresults object populated from the query conditions when no match is found
 *
 * @method     ChildCompetitorCompetitorresults findOneById(int $ID) Return the first ChildCompetitorCompetitorresults filtered by the ID column
 * @method     ChildCompetitorCompetitorresults findOneByCompetitorId(int $competitor_ID) Return the first ChildCompetitorCompetitorresults filtered by the competitor_ID column
 * @method     ChildCompetitorCompetitorresults findOneByCompetitorresults(double $COMPETITORRESULTS) Return the first ChildCompetitorCompetitorresults filtered by the COMPETITORRESULTS column
 * @method     ChildCompetitorCompetitorresults findOneByCompetitorresultsKey(int $COMPETITORRESULTS_KEY) Return the first ChildCompetitorCompetitorresults filtered by the COMPETITORRESULTS_KEY column *

 * @method     ChildCompetitorCompetitorresults requirePk($key, ConnectionInterface $con = null) Return the ChildCompetitorCompetitorresults by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompetitorCompetitorresults requireOne(ConnectionInterface $con = null) Return the first ChildCompetitorCompetitorresults matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCompetitorCompetitorresults requireOneById(int $ID) Return the first ChildCompetitorCompetitorresults filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompetitorCompetitorresults requireOneByCompetitorId(int $competitor_ID) Return the first ChildCompetitorCompetitorresults filtered by the competitor_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompetitorCompetitorresults requireOneByCompetitorresults(double $COMPETITORRESULTS) Return the first ChildCompetitorCompetitorresults filtered by the COMPETITORRESULTS column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompetitorCompetitorresults requireOneByCompetitorresultsKey(int $COMPETITORRESULTS_KEY) Return the first ChildCompetitorCompetitorresults filtered by the COMPETITORRESULTS_KEY column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCompetitorCompetitorresults[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCompetitorCompetitorresults objects based on current ModelCriteria
 * @method     ChildCompetitorCompetitorresults[]|ObjectCollection findById(int $ID) Return ChildCompetitorCompetitorresults objects filtered by the ID column
 * @method     ChildCompetitorCompetitorresults[]|ObjectCollection findByCompetitorId(int $competitor_ID) Return ChildCompetitorCompetitorresults objects filtered by the competitor_ID column
 * @method     ChildCompetitorCompetitorresults[]|ObjectCollection findByCompetitorresults(double $COMPETITORRESULTS) Return ChildCompetitorCompetitorresults objects filtered by the COMPETITORRESULTS column
 * @method     ChildCompetitorCompetitorresults[]|ObjectCollection findByCompetitorresultsKey(int $COMPETITORRESULTS_KEY) Return ChildCompetitorCompetitorresults objects filtered by the COMPETITORRESULTS_KEY column
 * @method     ChildCompetitorCompetitorresults[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CompetitorCompetitorresultsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CompetitorCompetitorresultsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'ezscore', $modelName = '\\CompetitorCompetitorresults', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCompetitorCompetitorresultsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCompetitorCompetitorresultsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCompetitorCompetitorresultsQuery) {
            return $criteria;
        }
        $query = new ChildCompetitorCompetitorresultsQuery();
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
     * @return ChildCompetitorCompetitorresults|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CompetitorCompetitorresultsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CompetitorCompetitorresultsTableMap::DATABASE_NAME);
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
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCompetitorCompetitorresults A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, competitor_ID, COMPETITORRESULTS, COMPETITORRESULTS_KEY FROM competitor_competitorresults WHERE ID = :p0';
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
            /** @var ChildCompetitorCompetitorresults $obj */
            $obj = new ChildCompetitorCompetitorresults();
            $obj->hydrate($row);
            CompetitorCompetitorresultsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCompetitorCompetitorresults|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
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
    public function findPks($keys, ConnectionInterface $con = null)
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
     * @return $this|ChildCompetitorCompetitorresultsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCompetitorCompetitorresultsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE ID = 1234
     * $query->filterById(array(12, 34)); // WHERE ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE ID > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompetitorCompetitorresultsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the competitor_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByCompetitorId(1234); // WHERE competitor_ID = 1234
     * $query->filterByCompetitorId(array(12, 34)); // WHERE competitor_ID IN (12, 34)
     * $query->filterByCompetitorId(array('min' => 12)); // WHERE competitor_ID > 12
     * </code>
     *
     * @see       filterByCompetitor()
     *
     * @param     mixed $competitorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompetitorCompetitorresultsQuery The current query, for fluid interface
     */
    public function filterByCompetitorId($competitorId = null, $comparison = null)
    {
        if (is_array($competitorId)) {
            $useMinMax = false;
            if (isset($competitorId['min'])) {
                $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_COMPETITOR_ID, $competitorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($competitorId['max'])) {
                $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_COMPETITOR_ID, $competitorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_COMPETITOR_ID, $competitorId, $comparison);
    }

    /**
     * Filter the query on the COMPETITORRESULTS column
     *
     * Example usage:
     * <code>
     * $query->filterByCompetitorresults(1234); // WHERE COMPETITORRESULTS = 1234
     * $query->filterByCompetitorresults(array(12, 34)); // WHERE COMPETITORRESULTS IN (12, 34)
     * $query->filterByCompetitorresults(array('min' => 12)); // WHERE COMPETITORRESULTS > 12
     * </code>
     *
     * @param     mixed $competitorresults The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompetitorCompetitorresultsQuery The current query, for fluid interface
     */
    public function filterByCompetitorresults($competitorresults = null, $comparison = null)
    {
        if (is_array($competitorresults)) {
            $useMinMax = false;
            if (isset($competitorresults['min'])) {
                $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_COMPETITORRESULTS, $competitorresults['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($competitorresults['max'])) {
                $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_COMPETITORRESULTS, $competitorresults['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_COMPETITORRESULTS, $competitorresults, $comparison);
    }

    /**
     * Filter the query on the COMPETITORRESULTS_KEY column
     *
     * Example usage:
     * <code>
     * $query->filterByCompetitorresultsKey(1234); // WHERE COMPETITORRESULTS_KEY = 1234
     * $query->filterByCompetitorresultsKey(array(12, 34)); // WHERE COMPETITORRESULTS_KEY IN (12, 34)
     * $query->filterByCompetitorresultsKey(array('min' => 12)); // WHERE COMPETITORRESULTS_KEY > 12
     * </code>
     *
     * @param     mixed $competitorresultsKey The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompetitorCompetitorresultsQuery The current query, for fluid interface
     */
    public function filterByCompetitorresultsKey($competitorresultsKey = null, $comparison = null)
    {
        if (is_array($competitorresultsKey)) {
            $useMinMax = false;
            if (isset($competitorresultsKey['min'])) {
                $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_COMPETITORRESULTS_KEY, $competitorresultsKey['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($competitorresultsKey['max'])) {
                $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_COMPETITORRESULTS_KEY, $competitorresultsKey['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_COMPETITORRESULTS_KEY, $competitorresultsKey, $comparison);
    }

    /**
     * Filter the query by a related \Competitor object
     *
     * @param \Competitor|ObjectCollection $competitor The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCompetitorCompetitorresultsQuery The current query, for fluid interface
     */
    public function filterByCompetitor($competitor, $comparison = null)
    {
        if ($competitor instanceof \Competitor) {
            return $this
                ->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_COMPETITOR_ID, $competitor->getId(), $comparison);
        } elseif ($competitor instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_COMPETITOR_ID, $competitor->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCompetitor() only accepts arguments of type \Competitor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Competitor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCompetitorCompetitorresultsQuery The current query, for fluid interface
     */
    public function joinCompetitor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Competitor');

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
            $this->addJoinObject($join, 'Competitor');
        }

        return $this;
    }

    /**
     * Use the Competitor relation Competitor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CompetitorQuery A secondary query class using the current class as primary query
     */
    public function useCompetitorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCompetitor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Competitor', '\CompetitorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCompetitorCompetitorresults $competitorCompetitorresults Object to remove from the list of results
     *
     * @return $this|ChildCompetitorCompetitorresultsQuery The current query, for fluid interface
     */
    public function prune($competitorCompetitorresults = null)
    {
        if ($competitorCompetitorresults) {
            $this->addUsingAlias(CompetitorCompetitorresultsTableMap::COL_ID, $competitorCompetitorresults->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the competitor_competitorresults table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompetitorCompetitorresultsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CompetitorCompetitorresultsTableMap::clearInstancePool();
            CompetitorCompetitorresultsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompetitorCompetitorresultsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CompetitorCompetitorresultsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CompetitorCompetitorresultsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CompetitorCompetitorresultsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CompetitorCompetitorresultsQuery
