CREATE TABLE users
(
    id       INTEGER      NOT NULL PRIMARY KEY AUTOINCREMENT,
    username NVARCHAR(20) NOT NULL,
    email    NVARCHAR(40) NOT NULL,
    pwd      NVARCHAR(45) NOT NULL
);
CREATE TABLE bills
(
    id     INTEGER      NOT NULL PRIMARY KEY AUTOINCREMENT,
    name   NVARCHAR(50) NOT NULL,
    amount REAL         NOT NULL,
    date   TEXT         NOT NULL,
    payee  INTEGER      NOT NULL,
    num    INTEGER      NOT NULL,
    status INTEGER      NOT NULL DEFAULT 0,
    FOREIGN KEY (payee) REFERENCES users (id)
);
CREATE TABLE splitbills
(
    id     INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    parent INTEGER NOT NULL,
    payer  INTEGER NOT NULL,
    amount REAL    NOT NULL,
    status INTEGER NOT NULL DEFAULT 0,
    FOREIGN KEY (payer) REFERENCES users (id),
    FOREIGN KEY (parent) REFERENCES bills (id)
);
CREATE TABLE groups
(
    id   INTEGER      NOT NULL PRIMARY KEY AUTOINCREMENT,
    name NVARCHAR(20) NOT NULL

);
CREATE TABLE members
(
    member  INTEGER NOT NULL,
    groupId INTEGER NOT NULL,
    FOREIGN KEY (member) REFERENCES users (id),
    FOREIGN KEY (groupId) REFERENCES groups (id)
);

CREATE TABLE bills
(
    id     INTEGER      NOT NULL PRIMARY KEY AUTOINCREMENT,
    name   NVARCHAR(50) NOT NULL,
    amount REAL         NOT NULL,
    date   TEXT         NOT NULL,
    payee  INTEGER      NOT NULL,
    num    INTEGER      NOT NULL,
    status INTEGER      NOT NULL DEFAULT 0,
    FOREIGN KEY (payee) REFERENCES users (id)
);

CREATE TABLE resetpwd
(
    id           INTEGER      NOT NULL PRIMARY KEY AUTOINCREMENT,
    email        NVARCHAR(50) NOT NULL,
    token        TEXT         NOT NULL,
    selector     TEXT         NOT NULL,
    tokenExpires TEXT         NOT NULL
);
