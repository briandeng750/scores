<?php

namespace Base;

use \MeetCompetitor as ChildMeetCompetitor;
use \MeetCompetitorQuery as ChildMeetCompetitorQuery;
use \Exception;
use \PDO;
use Map\MeetCompetitorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'meet_competitor' table.
 *
 *
 *
 * @method     ChildMeetCompetitorQuery orderByMeetId($order = Criteria::ASC) Order by the meet_ID column
 * @method     ChildMeetCompetitorQuery orderByCompetitorsId($order = Criteria::ASC) Order by the competitors_ID column
 *
 * @method     ChildMeetCompetitorQuery groupByMeetId() Group by the meet_ID column
 * @method     ChildMeetCompetitorQuery groupByCompetitorsId() Group by the competitors_ID column
 *
 * @method     ChildMeetCompetitorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMeetCompetitorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMeetCompetitorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMeetCompetitorQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMeetCompetitorQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMeetCompetitorQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMeetCompetitorQuery leftJoinCompetitor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Competitor relation
 * @method     ChildMeetCompetitorQuery rightJoinCompetitor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Competitor relation
 * @method     ChildMeetCompetitorQuery innerJoinCompetitor($relationAlias = null) Adds a INNER JOIN clause to the query using the Competitor relation
 *
 * @method     ChildMeetCompetitorQuery joinWithCompetitor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Competitor relation
 *
 * @method     ChildMeetCompetitorQuery leftJoinWithCompetitor() Adds a LEFT JOIN clause and with to the query using the Competitor relation
 * @method     ChildMeetCompetitorQuery rightJoinWithCompetitor() Adds a RIGHT JOIN clause and with to the query using the Competitor relation
 * @method     ChildMeetCompetitorQuery innerJoinWithCompetitor() Adds a INNER JOIN clause and with to the query using the Competitor relation
 *
 * @method     ChildMeetCompetitorQuery leftJoinMeet($relationAlias = null) Adds a LEFT JOIN clause to the query using the Meet relation
 * @method     ChildMeetCompetitorQuery rightJoinMeet($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Meet relation
 * @method     ChildMeetCompetitorQuery innerJoinMeet($relationAlias = null) Adds a INNER JOIN clause to the query using the Meet relation
 *
 * @method     ChildMeetCompetitorQuery joinWithMeet($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Meet relation
 *
 * @method     ChildMeetCompetitorQuery leftJoinWithMeet() Adds a LEFT JOIN clause and with to the query using the Meet relation
 * @method     ChildMeetCompetitorQuery rightJoinWithMeet() Adds a RIGHT JOIN clause and with to the query using the Meet relation
 * @method     ChildMeetCompetitorQuery innerJoinWithMeet() Adds a INNER JOIN clause and with to the query using the Meet relation
 *
 * @method     \CompetitorQuery|\MeetQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMeetCompetitor findOne(ConnectionInterface $con = null) Return the first ChildMeetCompetitor matching the query
 * @method     ChildMeetCompetitor findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMeetCompetitor matching the query, or a new ChildMeetCompetitor object populated from the query conditions when no match is found
 *
 * @method     ChildMeetCompetitor findOneByMeetId(int $meet_ID) Return the first ChildMeetCompetitor filtered by the meet_ID column
 * @method     ChildMeetCompetitor findOneByCompetitorsId(int $competitors_ID) Return the first ChildMeetCompetitor filtered by the competitors_ID column *

 * @method     ChildMeetCompetitor requirePk($key, ConnectionInterface $con = null) Return the ChildMeetCompetitor by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMeetCompetitor requireOne(ConnectionInterface $con = null) Return the first ChildMeetCompetitor matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMeetCompetitor requireOneByMeetId(int $meet_ID) Return the first ChildMeetCompetitor filtered by the meet_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMeetCompetitor requireOneByCompetitorsId(int $competitors_ID) Return the first ChildMeetCompetitor filtered by the competitors_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMeetCompetitor[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMeetCompetitor objects based on current ModelCriteria
 * @method     ChildMeetCompetitor[]|ObjectCollection findByMeetId(int $meet_ID) Return ChildMeetCompetitor objects filtered by the meet_ID column
 * @method     ChildMeetCompetitor[]|ObjectCollection findByCompetitorsId(int $competitors_ID) Return ChildMeetCompetitor objects filtered by the competitors_ID column
 * @method     ChildMeetCompetitor[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MeetCompetitorQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MeetCompetitorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'ezscore', $modelName = '\\MeetCompetitor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMeetCompetitorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMeetCompetitorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMeetCompetitorQuery) {
            return $criteria;
        }
        $query = new ChildMeetCompetitorQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$meet_ID, $competitors_ID] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMeetCompetitor|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MeetCompetitorTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MeetCompetitorTableMap::DATABASE_NAME);
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
     * @return ChildMeetCompetitor A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT meet_ID, competitors_ID FROM meet_competitor WHERE meet_ID = :p0 AND competitors_ID = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildMeetCompetitor $obj */
            $obj = new ChildMeetCompetitor();
            $obj->hydrate($row);
            MeetCompetitorTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildMeetCompetitor|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildMeetCompetitorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(MeetCompetitorTableMap::COL_MEET_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(MeetCompetitorTableMap::COL_COMPETITORS_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMeetCompetitorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(MeetCompetitorTableMap::COL_MEET_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(MeetCompetitorTableMap::COL_COMPETITORS_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the meet_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByMeetId(1234); // WHERE meet_ID = 1234
     * $query->filterByMeetId(array(12, 34)); // WHERE meet_ID IN (12, 34)
     * $query->filterByMeetId(array('min' => 12)); // WHERE meet_ID > 12
     * </code>
     *
     * @see       filterByMeet()
     *
     * @param     mixed $meetId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMeetCompetitorQuery The current query, for fluid interface
     */
    public function filterByMeetId($meetId = null, $comparison = null)
    {
        if (is_array($meetId)) {
            $useMinMax = false;
            if (isset($meetId['min'])) {
                $this->addUsingAlias(MeetCompetitorTableMap::COL_MEET_ID, $meetId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($meetId['max'])) {
                $this->addUsingAlias(MeetCompetitorTableMap::COL_MEET_ID, $meetId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeetCompetitorTableMap::COL_MEET_ID, $meetId, $comparison);
    }

    /**
     * Filter the query on the competitors_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByCompetitorsId(1234); // WHERE competitors_ID = 1234
     * $query->filterByCompetitorsId(array(12, 34)); // WHERE competitors_ID IN (12, 34)
     * $query->filterByCompetitorsId(array('min' => 12)); // WHERE competitors_ID > 12
     * </code>
     *
     * @see       filterByCompetitor()
     *
     * @param     mixed $competitorsId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMeetCompetitorQuery The current query, for fluid interface
     */
    public function filterByCompetitorsId($competitorsId = null, $comparison = null)
    {
        if (is_array($competitorsId)) {
            $useMinMax = false;
            if (isset($competitorsId['min'])) {
                $this->addUsingAlias(MeetCompetitorTableMap::COL_COMPETITORS_ID, $competitorsId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($competitorsId['max'])) {
                $this->addUsingAlias(MeetCompetitorTableMap::COL_COMPETITORS_ID, $competitorsId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeetCompetitorTableMap::COL_COMPETITORS_ID, $competitorsId, $comparison);
    }

    /**
     * Filter the query by a related \Competitor object
     *
     * @param \Competitor|ObjectCollection $competitor The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMeetCompetitorQuery The current query, for fluid interface
     */
    public function filterByCompetitor($competitor, $comparison = null)
    {
        if ($competitor instanceof \Competitor) {
            return $this
                ->addUsingAlias(MeetCompetitorTableMap::COL_COMPETITORS_ID, $competitor->getId(), $comparison);
        } elseif ($competitor instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MeetCompetitorTableMap::COL_COMPETITORS_ID, $competitor->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildMeetCompetitorQuery The current query, for fluid interface
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
     * Filter the query by a related \Meet object
     *
     * @param \Meet|ObjectCollection $meet The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMeetCompetitorQuery The current query, for fluid interface
     */
    public function filterByMeet($meet, $comparison = null)
    {
        if ($meet instanceof \Meet) {
            return $this
                ->addUsingAlias(MeetCompetitorTableMap::COL_MEET_ID, $meet->getId(), $comparison);
        } elseif ($meet instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MeetCompetitorTableMap::COL_MEET_ID, $meet->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMeet() only accepts arguments of type \Meet or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Meet relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMeetCompetitorQuery The current query, for fluid interface
     */
    public function joinMeet($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Meet');

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
            $this->addJoinObject($join, 'Meet');
        }

        return $this;
    }

    /**
     * Use the Meet relation Meet object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MeetQuery A secondary query class using the current class as primary query
     */
    public function useMeetQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMeet($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Meet', '\MeetQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMeetCompetitor $meetCompetitor Object to remove from the list of results
     *
     * @return $this|ChildMeetCompetitorQuery The current query, for fluid interface
     */
    public function prune($meetCompetitor = null)
    {
        if ($meetCompetitor) {
            $this->addCond('pruneCond0', $this->getAliasedColName(MeetCompetitorTableMap::COL_MEET_ID), $meetCompetitor->getMeetId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(MeetCompetitorTableMap::COL_COMPETITORS_ID), $meetCompetitor->getCompetitorsId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the meet_competitor table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MeetCompetitorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MeetCompetitorTableMap::clearInstancePool();
            MeetCompetitorTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MeetCompetitorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MeetCompetitorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MeetCompetitorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MeetCompetitorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MeetCompetitorQuery
