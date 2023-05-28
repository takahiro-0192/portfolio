CREATE TABLE `test_db`.`accounts` (
    `id`                      BIGINT           NOT NULL       AUTO_INCREMENT,
    `id_name`                 varchar(255)     DEFAULT NULL,
    `email`                   varchar(255)     DEFAULT NULL,
    `tel`                     varchar(255)     DEFAULT NULL,
    `password`                varchar(255)     DEFAULT NULL,
    `login_status`            INTEGER          DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;

CREATE TABLE `test_db`.`contact_list`(
    `id`        BIGINT          NOT NULL,
    `list_id`   BIGINT          NOT NULL,
    FOREIGN KEY (`id`)  REFERENCES `test_db`.`accounts` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `test_db`.`chat_1` (
    `message_id`           BIGINT          NOT NULL,
    `message`              varchar(2000)   NOT NULL,
    `to_id`                BIGINT          NOT NULL,
    `send_date`            TIMESTAMP       NOT NULL,
    `open`                 INTEGER         DEFAULT 0,
    FOREIGN KEY (`message_id`)  REFERENCES `test_db`.`accounts` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `test_db`.`chat_2` (
    `message_id`           BIGINT          NOT NULL,
    `message`              varchar(2000)   NOT NULL,
    `to_id`                BIGINT          NOT NULL,
    `send_date`            TIMESTAMP       NOT NULL,
    `open`                 INTEGER         DEFAULT 0,
    FOREIGN KEY (`message_id`)  REFERENCES `test_db`.`accounts` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `test_db`.`chat_room` (
    `room_no`              BIGINT          NOT NULL,
    `account_id`           BIGINT          NOT NULL,
    `from_id`              BIGINT          NOT NULL,
    FOREIGN KEY (`account_id`)  REFERENCES `test_db`.`accounts` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

