CREATE TABLE `accounts` (
    `id`                      BIGINT           NOT NULL       AUTO_INCREMENT,
    `date_of_Birth`           varchar(255)     DEFAULT NULL,
    `name`                    varchar(255)     DEFAULT NULL,
    `gender`                  varchar(255)     DEFAULT NULL,
    `email`                   varchar(255)     DEFAULT NULL,
    `password`                varchar(255)     DEFAULT NULL,
    `address1`                varchar(255)     DEFAULT NULL,
    `address2`                varchar(255)     DEFAULT NULL,
    `introduction`            varchar(255)     DEFAULT NULL,
    `login_status`            INTEGER          DEFAULT 0,
    `update_image_name`       varchar(255)     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `chat` (
    `message_id`           BIGINT          NOT NULL,
    `message_title`        varchar(255)    NOT NULL,
    `message`              varchar(3000)   NOT NULL,
    `name`                 varchar(255)    NOT NULL,
    `from_id`              BIGINT          NOT NULL,
    `from_name`            varchar(255)    NOT NULL,
    `send_date`            varchar(255)    NOT NULL,
    `open`                 INTEGER         DEFAULT 0,
    FOREIGN KEY (`message_id`)  REFERENCES `accounts` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
