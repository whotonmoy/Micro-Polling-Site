
-- Clean up tables
DROP TABLE IF EXISTS Users, Polls, Answers, Votes;

-- Users Table
CREATE TABLE Users (
        user_id INT NOT NULL AUTO_INCREMENT,
        email VARCHAR(255) NOT NULL,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        avatar_url VARCHAR(255),
        PRIMARY KEY (user_id)
    );


-- Polls table
CREATE TABLE Polls (
        poll_id INT NOT NULL AUTO_INCREMENT,
        user_id INT NOT NULL,
        question VARCHAR(255) NOT NULL,
        created_dt TIMESTAMP NOT NULL,
        open_dt TIMESTAMP NOT NULL,
        close_dt TIMESTAMP NOT NULL,
        last_vote_dt TIMESTAMP NOT NULL,
        PRIMARY KEY (poll_id),
        FOREIGN KEY (user_id) REFERENCES Users (user_id)
    );


-- Answers Table
CREATE TABLE Answers (
        ans_id INT NOT NULL AUTO_INCREMENT,
        poll_id INT NOT NULL,
        answer VARCHAR(255) NOT NULL,
        PRIMARY KEY (ans_id),
        FOREIGN KEY (poll_id) REFERENCES Polls (poll_id)
    );


-- Votes Tables
CREATE TABLE Votes (
        vote_id INT NOT NULL AUTO_INCREMENT,
        ans_id INT NOT NULL,
        vote_dt TIMESTAMP NOT NULL,
        PRIMARY KEY (vote_id),
        FOREIGN KEY (ans_id) REFERENCES Answers (ans_id)
    );