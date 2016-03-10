<?php

namespace Base;

use \MeetTeams as ChildMeetTeams;
use \MeetTeamsQuery as ChildMeetTeamsQuery;
use \Exception;
use \PDO;
use Map\MeetTeamsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'meet_teams' table.
 *
 *
 *
 * @method     ChildMeetTeamsQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildMeetTeamsQuery orderByMeetId($order = Criteria::ASC) Order by the meet_ID column
 * @method     ChildMeetTeamsQuery orderByTeams($order = Criteria::ASC) Order by the TEAMS column
 *
 * @method     ChildMeetTeamsQuery groupById() Group by the ID column
 * @method     ChildMeetTeamsQuery groupByMeetId() Group by the meet_ID column
 * @method     ChildMeetTeamsQuery groupByTeams() Group by the TEAMS column
 *
 * @method     ChildMeetTeamsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMeetTeamsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMeetTeamsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMeetTeamsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMeetTeamsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMeetTeamsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMeetTeams findOne(ConnectionInterface $con = null) Return the first ChildMeetTeams matching the query
 * @method     ChildMeetTeams findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMeetTeams matching the query, or a new ChildMeetTeams object populated from the query conditions when no match is found
 *
 * @method     ChildMeetTeams findOneById(int $ID) Return the first ChildMeetTeams filtered by the ID column
 * @method     ChildMeetTeams findOneByMeetId(int $meet_ID) Return the first ChildMeetTeams filtered by the meet_ID column
 * @method     ChildMeetTeams findOneByTeams(string $TEAMS) Return the first ChildMeetTeams filtered by the TEAMS column *

 * @method     ChildMeetTeams requirePk($key, ConnectionInterface $con = null) Return the ChildMeetTeams by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMeetTeams requireOne(ConnectionInterface $con = null) Return the first ChildMeetTeams matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMeetTeams requireOneById(int $ID) Return the first ChildMeetTeams filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMeetTeams requireOneByMeetId(int $meet_ID) Return the first ChildMeetTeams filtered by the meet_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMeetTeams requireOneByTeams(string $TEAMS) Return the first ChildMeetTeams filtered by the TEAMS column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMeetTeams[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMeetTeams objects based on current ModelCriteria
 * @method     ChildMeetTeams[]|ObjectCollection findById(int $ID) Return ChildMeetTeams objects filtered by the ID column
 * @method     ChildMeetTeams[]|ObjectCollection findByMeetId(int $meet_ID) Return ChildMeetTeams objects filtered by the meet_ID column
 * @method     ChildMeetTeams[]|ObjectCollection findByTeams(string $TEAMS) Return ChildMeetTeams objects filtered by the TEAMS column
 * @method     ChildMeetTeams[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MeetTeamsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MeetTeamsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'ezscore', $modelName = '\\MeetTeams', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMeetTeamsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMeetTeamsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMeetTeamsQuery) {
            return $criteria;
        }
        $query = new ChildMeetTeamsQuery();
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
     * @return ChildMeetTeams|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MeetTeamsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MeetTeamsTableMap::DATABASE_NAME);
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
     * @return ChildMeetTeams A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, meet_ID, TEAMS FROM meet_teams WHERE ID = :p0';
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
            /** @var ChildMeetTeams $obj */
            $obj = new ChildMeetTeams();
            $obj->hydrate($row);
            MeetTeamsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMeetTeams|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMeetTeamsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MeetTeamsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMeetTeamsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MeetTeamsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildMeetTeamsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MeetTeamsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MeetTeamsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeetTeamsTableMap::COL_ID, $id, $comparison);
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
     * @param     mixed $meetId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMeetTeamsQuery The current query, for fluid interface
     */
    public function filterByMeetId($meetId = null, $comparison = null)
    {
        if (is_array($meetId)) {
            $useMinMax = false;
            if (isset($meetId['min'])) {
                $this->addUsingAlias(MeetTeamsTableMap::COL_MEET_ID, $meetId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($meetId['max'])) {
                $this->addUsingAlias(MeetTeamsTableMap::COL_MEET_ID, $meetId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeetTeamsTableMap::COL_MEET_ID, $meetId, $comparison);
    }

    /**
     * Filter the query on the TEAMS column
     *
     * Example usage:
     * <code>
     * $query->filterByTeams('fooValue');   // WHERE TEAMS = 'fooValue'
     * $query->filterByTeams('%fooValue%'); // WHERE TEAMS LIKE '%fooValue%'
     * </code>
     *
     * @param     string $teams The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMeetTeamsQuery The current query, for fluid interface
     */
    public function filterByTeams($teams = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($teams)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $teams)) {
                $teams = str_replace('*', '%', $teams);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeetTeamsTableMap::COL_TEAMS, $teams, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMeetTeams $meetTeams Object to remove from the list of results
     *
     * @return $this|ChildMeetTeamsQuery The current query, for fluid interface
     */
    public function prune($meetTeams = null)
    {
        if ($meetTeams) {
            $this->addUsingAlias(MeetTeamsTableMap::COL_ID, $meetTeams->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the meet_teams table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MeetTeamsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MeetTeamsTableMap::clearInstancePool();
            MeetTeamsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MeetTeamsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MeetTeamsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MeetTeamsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MeetTeamsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MeetTeamsQuery
