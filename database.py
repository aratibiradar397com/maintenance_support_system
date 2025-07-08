import sqlite3

# Database connection and models

def connect_db():
    conn = sqlite3.connect('maintenance_support.db')
    return conn


def create_tables():
    conn = connect_db()
    cursor = conn.cursor()
    
    # Create Users table
    cursor.execute('''
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY,
        username TEXT UNIQUE,
        password TEXT,
        role TEXT
    )
    ''')
    
    # Create Issues table
    cursor.execute('''
    CREATE TABLE IF NOT EXISTS issues (
        id INTEGER PRIMARY KEY,
        user_id INTEGER,
        issue_type TEXT,
        department TEXT,
        room_no TEXT,
        description TEXT,
        status TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        resolved_at TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users (id)
    )
    ''')
    
    conn.commit()
    conn.close()

# Call create_tables() to initialize the database
create_tables()
