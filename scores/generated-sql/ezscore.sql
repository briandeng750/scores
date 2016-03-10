
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- HTCOMPETITOR
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `HTCOMPETITOR`;

CREATE TABLE `HTCOMPETITOR`
(
    `number` VARCHAR(255) NOT NULL,
    `category` VARCHAR(255),
    `name` VARCHAR(255),
    PRIMARY KEY (`number`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- TEAM
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `TEAM`;

CREATE TABLE `TEAM`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    PRIMARY KEY (`ID`),
    UNIQUE INDEX `name` (`name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- TEAM_MEMBER
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `TEAM_MEMBER`;

CREATE TABLE `TEAM_MEMBER`
(
    `number` VARCHAR(255) NOT NULL,
    `category` VARCHAR(255),
    `name` VARCHAR(255),
    PRIMARY KEY (`number`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- TEAM_TEAM_MEMBER
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `TEAM_TEAM_MEMBER`;

CREATE TABLE `TEAM_TEAM_MEMBER`
(
    `TEAM_ID` INTEGER NOT NULL,
    `members_number` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`TEAM_ID`,`members_number`),
    INDEX `FK_TEAM_TEAM_MEMBER_members_number` (`members_number`),
    CONSTRAINT `FK_TEAM_TEAM_MEMBER_members_number`
        FOREIGN KEY (`members_number`)
        REFERENCES `TEAM_MEMBER` (`number`),
    CONSTRAINT `FK_TEAM_TEAM_MEMBER_TEAM_ID`
        FOREIGN KEY (`TEAM_ID`)
        REFERENCES `TEAM` (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- competitor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `competitor`;

CREATE TABLE `competitor`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `category` VARCHAR(255),
    `name` VARCHAR(255),
    `number` VARCHAR(255),
    `team` VARCHAR(255),
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- competitor_competitorresults
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `competitor_competitorresults`;

CREATE TABLE `competitor_competitorresults`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `competitor_ID` INTEGER NOT NULL,
    `COMPETITORRESULTS` DOUBLE,
    `COMPETITORRESULTS_KEY` INTEGER NOT NULL,
    PRIMARY KEY (`ID`),
    INDEX `FK_competitor_COMPETITORRESULTS_competitor_ID` (`competitor_ID`),
    CONSTRAINT `FK_competitor_COMPETITORRESULTS_competitor_ID`
        FOREIGN KEY (`competitor_ID`)
        REFERENCES `competitor` (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- meet
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `meet`;

CREATE TABLE `meet`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `date` DATE,
    `description` VARCHAR(255),
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- meet_competitor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `meet_competitor`;

CREATE TABLE `meet_competitor`
(
    `meet_ID` INTEGER NOT NULL,
    `competitors_ID` INTEGER NOT NULL,
    PRIMARY KEY (`meet_ID`,`competitors_ID`),
    INDEX `FK_MEET_COMPETITOR_competitors_ID` (`competitors_ID`),
    CONSTRAINT `FK_MEET_COMPETITOR_competitors_ID`
        FOREIGN KEY (`competitors_ID`)
        REFERENCES `competitor` (`ID`),
    CONSTRAINT `FK_MEET_COMPETITOR_meet_ID`
        FOREIGN KEY (`meet_ID`)
        REFERENCES `meet` (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- meet_teams
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `meet_teams`;

CREATE TABLE `meet_teams`
(
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `meet_ID` INTEGER,
    `TEAMS` VARCHAR(255),
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ezs_users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ezs_users`;

CREATE TABLE `ezs_users`
(
    `ezs_user_id` INTEGER NOT NULL AUTO_INCREMENT,
    `ezs_username` VARCHAR(20),
    `ezs_password` VARCHAR(40),
    PRIMARY KEY (`ezs_user_id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
