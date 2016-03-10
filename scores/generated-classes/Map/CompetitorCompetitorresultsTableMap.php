<?php

namespace Map;

use \CompetitorCompetitorresults;
use \CompetitorCompetitorresultsQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'competitor_competitorresults' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CompetitorCompetitorresultsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.CompetitorCompetitorresultsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'ezscore';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'competitor_competitorresults';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\CompetitorCompetitorresults';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'CompetitorCompetitorresults';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'competitor_competitorresults.ID';

    /**
     * the column name for the competitor_ID field
     */
    const COL_COMPETITOR_ID = 'competitor_competitorresults.competitor_ID';

    /**
     * the column name for the COMPETITORRESULTS field
     */
    const COL_COMPETITORRESULTS = 'competitor_competitorresults.COMPETITORRESULTS';

    /**
     * the column name for the COMPETITORRESULTS_KEY field
     */
    const COL_COMPETITORRESULTS_KEY = 'competitor_competitorresults.COMPETITORRESULTS_KEY';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'CompetitorId', 'Competitorresults', 'CompetitorresultsKey', ),
        self::TYPE_CAMELNAME     => array('id', 'competitorId', 'competitorresults', 'competitorresultsKey', ),
        self::TYPE_COLNAME       => array(CompetitorCompetitorresultsTableMap::COL_ID, CompetitorCompetitorresultsTableMap::COL_COMPETITOR_ID, CompetitorCompetitorresultsTableMap::COL_COMPETITORRESULTS, CompetitorCompetitorresultsTableMap::COL_COMPETITORRESULTS_KEY, ),
        self::TYPE_FIELDNAME     => array('ID', 'competitor_ID', 'COMPETITORRESULTS', 'COMPETITORRESULTS_KEY', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'CompetitorId' => 1, 'Competitorresults' => 2, 'CompetitorresultsKey' => 3, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'competitorId' => 1, 'competitorresults' => 2, 'competitorresultsKey' => 3, ),
        self::TYPE_COLNAME       => array(CompetitorCompetitorresultsTableMap::COL_ID => 0, CompetitorCompetitorresultsTableMap::COL_COMPETITOR_ID => 1, CompetitorCompetitorresultsTableMap::COL_COMPETITORRESULTS => 2, CompetitorCompetitorresultsTableMap::COL_COMPETITORRESULTS_KEY => 3, ),
        self::TYPE_FIELDNAME     => array('ID' => 0, 'competitor_ID' => 1, 'COMPETITORRESULTS' => 2, 'COMPETITORRESULTS_KEY' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('competitor_competitorresults');
        $this->setPhpName('CompetitorCompetitorresults');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\CompetitorCompetitorresults');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('competitor_ID', 'CompetitorId', 'INTEGER', 'competitor', 'ID', true, null, null);
        $this->addColumn('COMPETITORRESULTS', 'Competitorresults', 'DOUBLE', false, null, null);
        $this->addColumn('COMPETITORRESULTS_KEY', 'CompetitorresultsKey', 'INTEGER', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Competitor', '\\Competitor', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':competitor_ID',
    1 => ':ID',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? CompetitorCompetitorresultsTableMap::CLASS_DEFAULT : CompetitorCompetitorresultsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (CompetitorCompetitorresults object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CompetitorCompetitorresultsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CompetitorCompetitorresultsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CompetitorCompetitorresultsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CompetitorCompetitorresultsTableMap::OM_CLASS;
            /** @var CompetitorCompetitorresults $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CompetitorCompetitorresultsTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = CompetitorCompetitorresultsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CompetitorCompetitorresultsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var CompetitorCompetitorresults $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CompetitorCompetitorresultsTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(CompetitorCompetitorresultsTableMap::COL_ID);
            $criteria->addSelectColumn(CompetitorCompetitorresultsTableMap::COL_COMPETITOR_ID);
            $criteria->addSelectColumn(CompetitorCompetitorresultsTableMap::COL_COMPETITORRESULTS);
            $criteria->addSelectColumn(CompetitorCompetitorresultsTableMap::COL_COMPETITORRESULTS_KEY);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.competitor_ID');
            $criteria->addSelectColumn($alias . '.COMPETITORRESULTS');
            $criteria->addSelectColumn($alias . '.COMPETITORRESULTS_KEY');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(CompetitorCompetitorresultsTableMap::DATABASE_NAME)->getTable(CompetitorCompetitorresultsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CompetitorCompetitorresultsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CompetitorCompetitorresultsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CompetitorCompetitorresultsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a CompetitorCompetitorresults or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CompetitorCompetitorresults object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompetitorCompetitorresultsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \CompetitorCompetitorresults) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CompetitorCompetitorresultsTableMap::DATABASE_NAME);
            $criteria->add(CompetitorCompetitorresultsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = CompetitorCompetitorresultsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CompetitorCompetitorresultsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CompetitorCompetitorresultsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the competitor_competitorresults table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CompetitorCompetitorresultsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CompetitorCompetitorresults or Criteria object.
     *
     * @param mixed               $criteria Criteria or CompetitorCompetitorresults object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompetitorCompetitorresultsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CompetitorCompetitorresults object
        }

        if ($criteria->containsKey(CompetitorCompetitorresultsTableMap::COL_ID) && $criteria->keyContainsValue(CompetitorCompetitorresultsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CompetitorCompetitorresultsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = CompetitorCompetitorresultsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CompetitorCompetitorresultsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CompetitorCompetitorresultsTableMap::buildTableMap();
