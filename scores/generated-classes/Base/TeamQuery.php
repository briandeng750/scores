<?php

namespace Base;

use \Team as ChildTeam;
use \TeamQuery as ChildTeamQuery;
use \Exception;
use \PDO;
use Map\TeamTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'TEAM' table.
 *
 *
 *
 * @method     ChildTeamQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildTeamQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildTeamQuery groupById() Group by the ID column
 * @method     ChildTeamQuery groupByName() Group by the name column
 *
 * @method     ChildTeamQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTeamQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTeamQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTeamQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTeamQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTeamQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTeamQuery leftJoinTeamTeamMember($relationAlias = null) Adds a LEFT JOIN clause to the query using the TeamTeamMember relation
 * @method     ChildTeamQuery rightJoinTeamTeamMember($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TeamTeamMember relation
 * @method     ChildTeamQuery innerJoinTeamTeamMember($relationAlias = null) Adds a INNER JOIN clause to the query using the TeamTeamMember relation
 *
 * @method     ChildTeamQuery joinWithTeamTeamMember($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TeamTeamMember relation
 *
 * @method     ChildTeamQuery leftJoinWithTeamTeamMember() Adds a LEFT JOIN clause and with to the query using the TeamTeamMember relation
 * @method     ChildTeamQuery rightJoinWithTeamTeamMember() Adds a RIGHT JOIN clause and with to the query using the TeamTeamMember relation
 * @method     ChildTeamQuery innerJoinWithTeamTeamMember() Adds a INNER JOIN clause and with to the query using the TeamTeamMember relation
 *
 * @method     \TeamTeamMemberQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTeam findOne(ConnectionInterface $con = null) Return the first ChildTeam matching the query
 * @method     ChildTeam findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTeam matching the query, or a new ChildTeam object populated from the query conditions when no match is found
 *
 * @method     ChildTeam findOneById(int $ID) Return the first ChildTeam filtered by the ID column
 * @method     ChildTeam findOneByName(string $name) Return the first ChildTeam filtered by the name column *

 * @method     ChildTeam requirePk($key, ConnectionInterface $con = null) Return the ChildTeam by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTeam requireOne(ConnectionInterface $con = null) Return the first ChildTeam matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTeam requireOneById(int $ID) Return the first ChildTeam filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTeam requireOneByName(string $name) Return the first ChildTeam filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTeam[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTeam objects based on current ModelCriteria
 * @method     ChildTeam[]|ObjectCollection findById(int $ID) Return ChildTeam objects filtered by the ID column
 * @method     ChildTeam[]|ObjectCollection findByName(string $name) Return ChildTeam objects filtered by the name column
 * @method     ChildTeam[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TeamQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TeamQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'ezscore', $modelName = '\\Team', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTeamQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTeamQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTeamQuery) {
            return $criteria;
        }
        $query = new ChildTeamQuery();
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
     * @return ChildTeam|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TeamTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TeamTableMap::DATABASE_NAME);
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
     * @return ChildTeam A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, name FROM TEAM WHERE ID = :p0';
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
            /** @var ChildTeam $obj */
            $obj = new ChildTeam();
            $obj->hydrate($row);
            TeamTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTeam|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTeamQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TeamTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTeamQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TeamTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTeamQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TeamTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TeamTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TeamTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildTeamQuery The current query, for fluid interface
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

        return $this->addUsingAlias(TeamTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \TeamTeamMember object
     *
     * @param \TeamTeamMember|ObjectCollection $teamTeamMember the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTeamQuery The current query, for fluid interface
     */
    public function filterByTeamTeamMember($teamTeamMember, $comparison = null)
    {
        if ($teamTeamMember instanceof \TeamTeamMember) {
            return $this
                ->addUsingAlias(TeamTableMap::COL_ID, $teamTeamMember->getTeamId(), $comparison);
        } elseif ($teamTeamMember instanceof ObjectCollection) {
            return $this
                ->useTeamTeamMemberQuery()
                ->filterByPrimaryKeys($teamTeamMember->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTeamTeamMember() only accepts arguments of type \TeamTeamMember or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TeamTeamMember relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTeamQuery The current query, for fluid interface
     */
    public function joinTeamTeamMember($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TeamTeamMember');

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
            $this->addJoinObject($join, 'TeamTeamMember');
        }

        return $this;
    }

    /**
     * Use the TeamTeamMember relation TeamTeamMember object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TeamTeamMemberQuery A secondary query class using the current class as primary query
     */
    public function useTeamTeamMemberQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTeamTeamMember($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TeamTeamMember', '\TeamTeamMemberQuery');
    }

    /**
     * Filter the query by a related TeamMember object
     * using the TEAM_TEAM_MEMBER table as cross reference
     *
     * @param TeamMember $teamMember the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTeamQuery The current query, for fluid interface
     */
    public function filterByTeamMember($teamMember, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useTeamTeamMemberQuery()
            ->filterByTeamMember($teamMember, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTeam $team Object to remove from the list of results
     *
     * @return $this|ChildTeamQuery The current query, for fluid interface
     */
    public function prune($team = null)
    {
        if ($team) {
            $this->addUsingAlias(TeamTableMap::COL_ID, $team->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the TEAM table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TeamTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TeamTableMap::clearInstancePool();
            TeamTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TeamTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TeamTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TeamTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TeamTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TeamQuery
