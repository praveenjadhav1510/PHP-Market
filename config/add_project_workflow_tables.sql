-- SQL helper to add workflow tables for project applications and assignments
-- Run this manually in your MySQL (e.g. via phpMyAdmin) against the `php_dev_marketplace` database.

CREATE TABLE IF NOT EXISTS project_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    developer_id INT NOT NULL,
    proposal TEXT NOT NULL,
    expected_budget INT NULL,
    expected_days INT NULL,
    status ENUM('applied','approved','rejected') DEFAULT 'applied',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_app_project
        FOREIGN KEY (project_id) REFERENCES projects(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_app_developer
        FOREIGN KEY (developer_id) REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT uniq_app_per_project_dev
        UNIQUE (project_id, developer_id)
);

CREATE TABLE IF NOT EXISTS project_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    developer_id INT NOT NULL,
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    status ENUM('in_progress','completed') DEFAULT 'in_progress',

    CONSTRAINT fk_assign_project
        FOREIGN KEY (project_id) REFERENCES projects(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_assign_developer
        FOREIGN KEY (developer_id) REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT uniq_assignment_per_project
        UNIQUE (project_id)
);




