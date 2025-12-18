-- SQL helper to add project invitations table
-- Run this manually in your MySQL (e.g. via phpMyAdmin) against the `php_dev_marketplace` database.

CREATE TABLE IF NOT EXISTS project_invitations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    developer_id INT NOT NULL,
    client_id INT NOT NULL,
    message TEXT NULL,
    status ENUM('pending','accepted','rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_invite_project
        FOREIGN KEY (project_id) REFERENCES projects(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_invite_developer
        FOREIGN KEY (developer_id) REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_invite_client
        FOREIGN KEY (client_id) REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT uniq_invite_per_project_dev
        UNIQUE (project_id, developer_id),

    INDEX idx_project_id (project_id),
    INDEX idx_developer_id (developer_id),
    INDEX idx_client_id (client_id),
    INDEX idx_status (status)
);


