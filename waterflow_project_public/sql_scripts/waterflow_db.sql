DROP DATABASE IF EXISTS waterflow_db;

CREATE DATABASE IF NOT EXISTS waterflow_db COLLATE utf8_unicode_ci;

-- Create super manager account

CREATE USER 'Please input a suitable username' @localhost IDENTIFIED BY 'Please input a password';
GRANT SELECT, INSERT, UPDATE, DELETE ON waterflow_db.* TO 'Created username'@localhost;

USE waterflow_db;

DROP TABLE IF EXISTS clearance;
CREATE TABLE clearance (
    `clearance_id` int(1) unsigned NOT NULL,
    `clearance_level_description` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    CONSTRAINT clearance_id PRIMARY KEY (clearance_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    `user_id` int unsigned NOT NULL AUTO_INCREMENT,
    `user_first_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    `user_last_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    `user_username` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
    `user_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `clearance_id` int(1) unsigned COLLATE utf8_unicode_ci NOT NULL,
    CONSTRAINT user_id PRIMARY KEY (user_id),
    CONSTRAINT `clearance_id` FOREIGN KEY (clearance_id)
        REFERENCES clearance(clearance_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS project;
CREATE TABLE project (
    `project_id` int(100) unsigned NOT NULL AUTO_INCREMENT,
    `project_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    `project_manager` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    `project_client` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    `project_due_date` varchar(20) COLLATE utf8_unicode_ci,
    `project_finished` boolean,
    CONSTRAINT project_id PRIMARY KEY (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS task;
CREATE TABLE task (
    `task_id` int(200) unsigned NOT NULL AUTO_INCREMENT,
    `project_id` int(100) unsigned NOT NULL,
    `task_description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
    `task_assigned` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
    `task_due_date` varchar(10),
    `task_completed` boolean,
    CONSTRAINT task_id PRIMARY KEY (task_id),
    CONSTRAINT `project_id` FOREIGN KEY (project_id)
        REFERENCES project(project_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS team;
CREATE TABLE team (
    `user_username` varchar(10) NOT NULL,
    `team_name` varchar(10) NOT NULL COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `clearance` (`clearance_id`, `clearance_level_description`)
VALUES ('1', 'Dummy Test'), ('2', 'Stakeholder level'), ('3', 'Developer level'), ('4', 'Manager level'),
       ('5', 'Supermanager level');

INSERT INTO `users` (`user_first_name`, `user_last_name`, `user_username`, `user_password`, `clearance_id`)
VALUES ('James', 'Smith', 'jams', '$2y$12$zvojpcNYiiGr/zG9RrTbruU5zaZlKKuV5YvFXh43hgsftBi75CSuq', '4');

INSERT INTO `users` (`user_first_name`, `user_last_name`, `user_username`, `user_password`, `clearance_id`)
VALUES ('James', 'Smith', 'jam', '$2y$12$zvojpcNYiiGr/zG9RrTbruU5zaZlKKuV5YvFXh43hgsftBi75CSuq', '1');

INSERT INTO `users` (`user_first_name`, `user_last_name`, `user_username`, `user_password`, `clearance_id`)
VALUES ('John', 'Doe', 'jond', '$2y$12$zvojpcNYiiGr/zG9RrTbruU5zaZlKKuV5YvFXh43hgsftBi75CSuq', '4');

INSERT INTO `users` (`user_first_name`, `user_last_name`, `user_username`, `user_password`, `clearance_id`)
VALUES ('Michael', 'Judd', 'mjudd', '$2y$12$0gzRCrZ.2xL3usC/ZrmADe5/i8WKotJhlju/p2pqgtKFA4tpb69iO', '3');

INSERT INTO `users` (`user_first_name`, `user_last_name`, `user_username`, `user_password`, `clearance_id`)
VALUES ('Clark', 'Kent', 'ckent', '$2y$12$q9fECLooU32fTTE.4Iw6POIinCiFhLq9jinr91JYqpsXBRMUc/Eai', '5');

INSERT INTO `users` (`user_first_name`, `user_last_name`, `user_username`, `user_password`, `clearance_id`)
VALUES ('Jons', 'Pritt', 'jpritt', '$2y$12$zvojpcNYiiGr/zG9RrTbruU5zaZlKKuV5YvFXh43hgsftBi75CSuq', '3');

INSERT INTO `users` (`user_first_name`, `user_last_name`, `user_username`, `user_password`, `clearance_id`)
VALUES ('Holly', 'H', 'hlh', '$2y$12$zvojpcNYiiGr/zG9RrTbruU5zaZlKKuV5YvFXh43hgsftBi75CSuq', '2');

INSERT INTO `users` (`user_first_name`, `user_last_name`, `user_username`, `user_password`, `clearance_id`)
VALUES ('Jordan', 'Smith', 'jms', '$2y$12$zvojpcNYiiGr/zG9RrTbruU5zaZlKKuV5YvFXh43hgsftBi75CSuq', '2');

INSERT INTO `users` (`user_first_name`, `user_last_name`, `user_username`, `user_password`, `clearance_id`)
VALUES ('JJ', 'Smith', 'jj', '$2y$12$zvojpcNYiiGr/zG9RrTbruU5zaZlKKuV5YvFXh43hgsftBi75CSuq', '2');

INSERT INTO `project` (`project_name`,`project_manager`, `project_client`, `project_due_date`, `project_finished`)
VALUES ('First project', 'James Smith', 'jms', '2023-01-02', 0);

INSERT INTO `project` (`project_name`,`project_manager`, `project_client`, `project_due_date`, `project_finished`)
VALUES ('Second project', 'James Smith', 'hlh', '2023-06-12', 0);

INSERT INTO `project` (`project_name`,`project_manager`, `project_client`, `project_due_date`, `project_finished`)
VALUES ('Third project', 'Clark Kent', 'jj', '2023-09-12', 0);

INSERT INTO `project` (`project_name`,`project_manager`, `project_client`, `project_due_date`, `project_finished`)
VALUES ('Fourth project', 'James Smith', 'jms', '2024-01-02', 0);

INSERT INTO `task` (`project_id`,`task_description`, `task_assigned`, `task_due_date`, `task_completed`)
VALUES ('1', 'First Assignment', 'mjudd', '2024-01-14', true);

INSERT INTO `task` (`project_id`,`task_description`, `task_assigned`, `task_due_date`, `task_completed`)
VALUES ('1', 'Second Assignment', 'jpritt', '2024-04-14', false);

INSERT INTO `task` (`project_id`,`task_description`, `task_assigned`, `task_due_date`, `task_completed`)
VALUES ('1', 'Third Assignment', 'mjudd', '2024-04-14', false);

INSERT INTO `task` (`project_id`,`task_description`, `task_assigned`, `task_due_date`, `task_completed`)
VALUES ('2', 'Test component', 'mjudd', '2024-09-19', false);