-- AshaParth AI Multiservices website: database schema
-- Import in phpMyAdmin (Import tab) or run:  mysql -u USER -p DBNAME < database/schema.sql
-- MySQL 5.7+ / MariaDB 10.3+

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS contact_enquiries (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name        VARCHAR(100)  NOT NULL,
    email       VARCHAR(150)  NOT NULL,
    phone       VARCHAR(20)   NOT NULL,
    subject     VARCHAR(150)  NOT NULL,
    message     TEXT          NOT NULL,
    status      ENUM('new','contacted','closed') NOT NULL DEFAULT 'new',
    ip_address  VARCHAR(45)   NOT NULL,
    user_agent  VARCHAR(255)  NULL,
    created_at  DATETIME      NOT NULL,
    PRIMARY KEY (id),
    KEY idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS quote_requests (
    id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name            VARCHAR(100)  NOT NULL,
    email           VARCHAR(150)  NOT NULL,
    phone           VARCHAR(20)   NOT NULL,
    company         VARCHAR(150)  NULL,
    country         VARCHAR(100)  NOT NULL,
    services        VARCHAR(500)  NOT NULL,
    budget          VARCHAR(50)   NOT NULL,
    timeline        VARCHAR(60)   NOT NULL,
    details         TEXT          NOT NULL,
    contact_method  VARCHAR(30)   NULL,
    referral        VARCHAR(50)   NULL,
    attachment_path VARCHAR(255)  NULL,
    attachment_name VARCHAR(150)  NULL,
    status          ENUM('new','contacted','proposal-sent','won','lost') NOT NULL DEFAULT 'new',
    ip_address      VARCHAR(45)   NOT NULL,
    user_agent      VARCHAR(255)  NULL,
    created_at      DATETIME      NOT NULL,
    PRIMARY KEY (id),
    KEY idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS career_applications (
    id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name          VARCHAR(100)  NOT NULL,
    email         VARCHAR(150)  NOT NULL,
    phone         VARCHAR(20)   NOT NULL,
    city          VARCHAR(100)  NOT NULL,
    position      VARCHAR(100)  NOT NULL,
    experience    VARCHAR(30)   NOT NULL,
    portfolio_url VARCHAR(255)  NULL,
    cover_note    TEXT          NULL,
    resume_path   VARCHAR(255)  NOT NULL,
    resume_name   VARCHAR(150)  NOT NULL,
    status        ENUM('new','shortlisted','interviewed','hired','rejected') NOT NULL DEFAULT 'new',
    ip_address    VARCHAR(45)   NOT NULL,
    user_agent    VARCHAR(255)  NULL,
    created_at    DATETIME      NOT NULL,
    PRIMARY KEY (id),
    KEY idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS temple_registrations (
    id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    temple_name   VARCHAR(150)  NOT NULL,
    deity         VARCHAR(100)  NULL,
    village_city  VARCHAR(100)  NOT NULL,
    taluka        VARCHAR(100)  NULL,
    district      VARCHAR(60)   NOT NULL,
    contact_name  VARCHAR(100)  NOT NULL,
    designation   VARCHAR(50)   NOT NULL,
    phone         VARCHAR(20)   NOT NULL,
    email         VARCHAR(150)  NULL,
    services      VARCHAR(500)  NOT NULL,
    existing_url  VARCHAR(255)  NULL,
    message       TEXT          NULL,
    status        ENUM('new','contacted','onboarded','closed') NOT NULL DEFAULT 'new',
    ip_address    VARCHAR(45)   NOT NULL,
    user_agent    VARCHAR(255)  NULL,
    created_at    DATETIME      NOT NULL,
    PRIMARY KEY (id),
    KEY idx_district (district),
    KEY idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS rate_limits (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    ip         VARCHAR(45)  NOT NULL,
    form       VARCHAR(20)  NOT NULL,
    created_at DATETIME     NOT NULL,
    PRIMARY KEY (id),
    KEY idx_lookup (ip, form, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
