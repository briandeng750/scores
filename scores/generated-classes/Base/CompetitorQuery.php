<?php

namespace Base;

use \Competitor as ChildCompetitor;
use \CompetitorQuery as ChildCompetitorQuery;
use \Exception;
use \PDO;
use Map\CompetitorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'competitor' table.
 *
 *
 *
 * @method     ChildCompetitorQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildCompetitorQuery orderByCategory($order = Criteria::ASC) Order by the category column
 * @method     ChildCompetitorQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildCompetitorQuery orderByNumber($order = Criteria::ASC) Order by the number column
 * @method     ChildCompetitorQuery orderByTeam($order = Criteria::ASC) Order by the team column
 *
 * @method     ChildCompetitorQuery groupById() Group by the ID column
 * @method     ChildCompetitorQuery groupByCategory() Group by the category column
 * @method     ChildCompetitorQuery groupByName() Group by the name column
 * @method     ChildCompetitorQuery groupByNumber() Group by the number column
 * @method     ChildCompetitorQuery groupByTeam() Group by the team column
 *
 * @method     ChildCompetitorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCompetitorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCompetitorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCompetitorQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCompetitorQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCompetitorQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCompetitorQuery leftJoinCompetitorCompetitorresults($relationAlias = null) Adds a LEFT JOIN clause to the query using the CompetitorCompetitorresults relation
 * @method     ChildCompetitorQuery rightJoinCompetitorCompetitorresults($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CompetitorCompetitorresults relation
 * @method     ChildCompetitorQuery innerJoinCompetitorCompetitorresults($relationAlias = null) Adds a INNER JOIN clause to the query using the CompetitorCompetitorresults relation
 *
 * @method     ChildCompetitorQuery joinWithCompetitorCompetitorresults($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CompetitorCompetitorresults relation
 *
 * @method     ChildCompetitorQuery leftJoinWithCompetitorCompetitorresults() Adds a LEFT JOIN clause and with to the query using the CompetitorCompetitorresults relation
 * @method     ChildCompetitorQuery rightJoinWithCompetitorCompetitorresults() Adds a RIGHT JOIN clause and with to the query using the CompetitorCompetitorresults relation
 * @method     ChildCompetitorQuery innerJoinWithCompetitorCompetitorresults() Adds a INNER JOIN clause and with to the query using the CompetitorCompetitorresults relation
 *
 * @method     ChildCompetitorQuery leftJoinMeetCompetitor($relationAlias = null) Adds a LEFT JOIN clause to the query using the MeetCompetitor relation
 * @method     ChildCompetitorQuery rightJoinMeetCompetitor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MeetCompetitor relation
 * @method     ChildCompetitorQuery innerJoinMeetCompetitor($relationAlias = null) Adds a INNER JOIN clause to the query using the MeetCompetitor relation
 *
 * @method     ChildCompetitorQuery joinWithMeetCompetitor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MeetCompetitor relation
 *
 * @method     ChildCompetitorQuery leftJoinWithMeetCompetitor() Adds a LEFT JOIN clause and with to the query using the MeetCompetitor relation
 * @method     ChildCompetitorQuery rightJoinWithMeetCompetitor() Adds a RIGHT JOIN clause and with to the query using the MeetCompetitor relation
 * @method     ChildCompetitorQuery innerJoinWithMeetCompetitor() Adds a INNER JOIN clause and with to the query using the MeetCompetitor relation
 *
 * @method     \CompetitorCompetitorresultsQuery|\MeetCompetitorQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCompetitor findOne(ConnectionInterface $con = null) Return the first ChildCompetitor matching the query
 * @method     ChildCompetitor findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCompetitor matching the query, or a new ChildCompetitor object populated from the query conditions when no match is found
 *
 * @method     ChildCompetitor findOneById(int $ID) Return the first ChildCompetitor filtered by the ID column
 * @method     ChildCompetitor findOneByCategory(string $category) Return the first ChildCompetitor filtered by the category column
 * @method     ChildCompetitor findOneByName(string $name) Return the first ChildCompetitor filtered by the name column
 * @method     ChildCompetitor findOneByNumber(string $number) Return the first ChildCompetitor filtered by the number column
 * @method     ChildCompetitor findOneByTeam(string $team) Return the first ChildCompetitor filtered by the team column *

 * @method     ChildCompetitor requirePk($key, ConnectionInterface $con = null) Return the ChildCompetitor by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompetitor requireOne(ConnectionInterface $con = null) Return the first ChildCompetitor matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCompetitor requireOneById(int $ID) Return the first ChildCompetitor filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompetitor requireOneByCategory(string $category) Return the first ChildCompetitor filtered by the category column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompetitor requireOneByName(string $name) Return the first ChildCompetitor filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompetitor requireOneByNumber(string $number) Return the first ChildCompetitor filtered by the number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCompetitor requireOneByTeam(string $team) Return the first ChildCompetitor filtered by the team column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCompetitor[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCompetitor objects based on current ModelCriteria
 * @method     ChildCompetitor[]|ObjectCollection findById(int $ID) Return ChildCompetitor objects filtered by the ID column
 * @method     ChildCompetitor[]|ObjectCollection findByCategory(string $category) Return ChildCompetitor objects filtered by the category column
 * @method     ChildCompetitor[]|ObjectCollection findByName(string $name) Return ChildCompetitor objects filtered by the name column
 * @method     ChildCompetitor[]|ObjectCollection findByNumber(string $number) Return ChildCompetitor objects filtered by the number column
 * @method     ChildCompetitor[]|ObjectCollection findByTeam(string $team) Return ChildCompetitor objects filtered by the team column
 * @method     ChildCompetitor[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CompetitorQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CompetitorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'ezscore', $modelName = '\\Competitor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCompetitorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCompetitorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCompetitorQuery) {
            return $criteria;
        }
        $query = new ChildCompetitorQuery();
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
     * @return ChildCompetitor|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CompetitorTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CompetitorTableMap::DATABASE_NAME);
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
     * @return ChildCompetitor A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, category, name, number, team FROM competitor WHERE ID = :p0';
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
            /** @var ChildCompetitor $obj */
            $obj = new ChildCompetitor();
            $obj->hydrate($row);
            CompetitorTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCompetitor|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCompetitorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CompetitorTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCompetitorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CompetitorTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCompetitorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CompetitorTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CompetitorTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompetitorTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the category column
     *
     * Example usage:
     * <code>
     * $query->filterByCategory('fooValue');   // WHERE category = 'fooValue'
     * $query->filterByCategory('%fooValue%'); // WHERE category LIKE '%fooValue%'
     * </code>
     *
     * @param     string $category The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompetitorQuery The current query, for fluid interface
     */
    public function filterByCategory($category = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($category)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $category)) {
                $category = str_replace('*', '%', $category);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompetitorTableMap::COL_CATEGORY, $category, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompetitorQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompetitorTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the number column
     *
     * Example usage:
     * <code>
     * $query->filterByNumber('fooValue');   // WHERE number = 'fooValue'
     * $query->filterByNumber('%fooValue%'); // WHERE number LIKE '%fooValue%'
     * </code>
     *
     * @param     string $number The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompetitorQuery The current query, for fluid interface
     */
    public function filterByNumber($number = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($number)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $number)) {
                $number = str_replace('*', '%', $number);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompetitorTableMap::COL_NUMBER, $number, $comparison);
    }

    /**
     * Filter the query on the team column
     *
     * Example usage:
     * <code>
     * $query->filterByTeam('fooValue');   // WHERE team = 'fooValue'
     * $query->filterByTeam('%fooValue%'); // WHERE team LIKE '%fooValue%'
     * </code>
     *
     * @param     string $team The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCompetitorQuery The current query, for fluid interface
     */
    public function filterByTeam($team = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($team)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $team)) {
                $team = str_replace('*', '%', $team);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompetitorTableMap::COL_TEAM, $team, $comparison);
    }

    /**
     * Filter the query by a related \CompetitorCompetitorresults object
     *
     * @param \CompetitorCompetitorresults|ObjectCollection $competitorCompetitorresults the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompetitorQuery The current query, for fluid interface
     */
    public function filterByCompetitorCompetitorresults($competitorCompetitorresults, $comparison = null)
    {
        if ($competitorCompetitorresults instanceof \CompetitorCompetitorresults) {
            return $this
                ->addUsingAlias(CompetitorTableMap::COL_ID, $competitorCompetitorresults->getCompetitorId(), $comparison);
        } elseif ($competitorCompetitorresults instanceof ObjectCollection) {
            return $this
                ->useCompetitorCompetitorresultsQuery()
                ->filterByPrimaryKeys($competitorCompetitorresults->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCompetitorCompetitorresults() only accepts arguments of type \CompetitorCompetitorresults or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CompetitorCompetitorresults relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCompetitorQuery The current query, for fluid interface
     */
    public function joinCompetitorCompetitorresults($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CompetitorCompetitorresults');

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
            $this->addJoinObject($join, 'CompetitorCompetitorresults');
        }

        return $this;
    }

    /**
     * Use the CompetitorCompetitorresults relation CompetitorCompetitorresults object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CompetitorCompetitorresultsQuery A secondary query class using the current class as primary query
     */
    public function useCompetitorCompetitorresultsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCompetitorCompetitorresults($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CompetitorCompetitorresults', '\CompetitorCompetitorresultsQuery');
    }

    /**
     * Filter the query by a related \MeetCompetitor object
     *
     * @param \MeetCompetitor|ObjectCollection $meetCompetitor the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompetitorQuery The current query, for fluid interface
     */
    public function filterByMeetCompetitor($meetCompetitor, $comparison = null)
    {
        if ($meetCompetitor instanceof \MeetCompetitor) {
            return $this
                ->addUsingAlias(CompetitorTableMap::COL_ID, $meetCompetitor->getCompetitorsId(), $comparison);
        } elseif ($meetCompetitor instanceof ObjectCollection) {
            return $this
                ->useMeetCompetitorQuery()
                ->filterByPrimaryKeys($meetCompetitor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMeetCompetitor() only accepts arguments of type \MeetCompetitor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MeetCompetitor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCompetitorQuery The current query, for fluid interface
     */
    public function joinMeetCompetitor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MeetCompetitor');

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
            $this->addJoinObject($join, 'MeetCompetitor');
        }

        return $this;
    }

    /**
     * Use the MeetCompetitor relation MeetCompetitor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MeetCompetitorQuery A secondary query class using the current class as primary query
     */
    public function useMeetCompetitorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMeetCompetitor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MeetCompetitor', '\MeetCompetitorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCompetitor $competitor Object to remove from the list of results
     *
     * @return $this|ChildCompetitorQuery The current query, for fluid interface
     */
    public function prune($competitor = null)
    {
        if ($competitor) {
            $this->addUsingAlias(CompetitorTableMap::COL_ID, $competitor->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the competitor table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompetitorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CompetitorTableMap::clearInstancePool();
            CompetitorTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CompetitorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CompetitorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CompetitorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CompetitorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CompetitorQuery
