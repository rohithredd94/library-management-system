
DROP DATABASE IF EXISTS library;
CREATE DATABASE library;

USE library;

DROP TABLE IF EXISTS book;
CREATE TABLE book (
  /*Dname         VARCHAR(25) NOT NULL,
  Dnumber       INT NOT NULL,
  Mgr_ssn       CHAR(9) NOT NULL, 
  Mgr_start_date DATE,
  CONSTRAINT pk_book PRIMARY KEY (dnumber),
  CONSTRAINT uk_dname UNIQUE (dname)*/
  isbn          BIGINT NOT NULL,
  title         VARCHAR(200) NOT NULL,
  cover         VARCHAR(50),
  CONSTRAINT pk_book PRIMARY KEY (isbn)
);

/*INSERT INTO book VALUES (9780881849806,'The Mind Cage','http://www.openisbn.com/cover/0881849804_72.jpg');*/

DROP TABLE IF EXISTS authors;
CREATE TABLE authors (
    author_id   INT NOT NULL,
    author_name VARCHAR(60),
    CONSTRAINT pk_authors PRIMARY KEY (author_id)
);

DROP TABLE IF EXISTS book_authors;
CREATE TABLE book_authors (
    author_id   INT NOT NULL,
    isbn        BIGINT NOT NULL,
    CONSTRAINT pk_book_authors PRIMARY KEY (author_id, isbn),
    CONSTRAINT fk_author_id FOREIGN KEY (author_id) references authors(author_id),
    CONSTRAINT fk_isbn FOREIGN KEY (isbn) references book(isbn)
);

DROP TABLE IF EXISTS borrowers;
CREATE TABLE borrowers (
    card_id     CHAR(8) NOT NULL,
    Ssn         CHAR(11) NOT NULL,
    Bname       VARCHAR(25) NOT NULL,
    Address     VARCHAR(60),
    Phone       CHAR(14),
    CONSTRAINT pk_borrowers PRIMARY KEY (card_id),
    CONSTRAINT uk_ssn UNIQUE (Ssn)

);

DROP TABLE IF EXISTS book_loans;
CREATE TABLE book_loans (
    loan_id     INT NOT NULL AUTO_INCREMENT,
    isbn        BIGINT NOT NULL,
    card_id     CHAR(8) NOT NULL,
    date_out    DATE NOT NULL,
    due_date    DATE NOT NULL,
    date_in     DATE NOT NULL,
    CONSTRAINT pk_book_loans PRIMARY KEY (loan_id),
    CONSTRAINT fk_loans_isbn FOREIGN KEY (isbn) references book(isbn),
    CONSTRAINT fk_loans_cardid FOREIGN KEY (card_id) references borrowers(card_id)

);

DROP TABLE IF EXISTS fines;
CREATE TABLE fines (
    loan_id     INT NOT NULL,
    fine_amt    DECIMAL(8,2),
    paid        BOOLEAN,
    CONSTRAINT pk_fines PRIMARY KEY (loan_id),
    CONSTRAINT fk_fines_loanid FOREIGN KEY (loan_id) references book_loans(loan_id)        
);

DROP TABLE IF EXISTS auth_users;
CREATE TABLE auth_users (
    username    VARCHAR(24) NOT NULL,
    password    VARCHAR(24) NOT NULL,
    name        VARCHAR(20),
    CONSTRAINT pk_users PRIMARY KEY (username)
);