document.addEventListener('DOMContentLoaded', () => {
    const userForm = document.getElementById('userForm');
    const userTableBody = document.getElementById('userTableBody');

    let db;

    // Open IndexedDB database
    const request = window.indexedDB.open('users', 1);

    request.onerror = function(event) {
        console.log('Database error: ' + event.target.errorCode);
    };

    request.onsuccess = function(event) {
        console.log('Database opened successfully');
        db = event.target.result;
        renderUsers();
    };

    request.onupgradeneeded = function(event) {
        console.log('Database upgrade needed');
        db = event.target.result;
        const objectStore = db.createObjectStore('user', { keyPath: 'id', autoIncrement: true });
        objectStore.createIndex('name', 'name', { unique: false });
        objectStore.createIndex('job', 'job', { unique: false });
        objectStore.createIndex('age', 'age', { unique: false });
    };

    userForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const name = document.getElementById('name').value;
        const job = document.getElementById('job').value;
        const age = document.getElementById('age').value;

        saveUser({ name: name, job: job, age: age });
        renderUsers();
        userForm.reset();
    });

    function saveUser(user) {
        const transaction = db.transaction(['user'], 'readwrite');
        const objectStore = transaction.objectStore('user');
        const request = objectStore.add(user);

        request.onsuccess = function(event) {
            console.log('User saved successfully');
        };

        request.onerror = function(event) {
            console.log('Error saving user: ' + event.target.errorCode);
        };
    }

    function renderUsers() {
        userTableBody.innerHTML = '';

        const transaction = db.transaction(['user'], 'readonly');
        const objectStore = transaction.objectStore('user');
        const request = objectStore.getAll();

        request.onsuccess = function(event) {
            const users = event.target.result;
            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.name}</td>
                    <td>${user.job}</td>
                    <td>${user.age}</td>
                    <td><button class="btn btn-danger btn-sm delete-btn" data-id="${user.id}">Delete</button></td>
                `;
                userTableBody.appendChild(row);
            });
            setupDeleteButtons();
        };
    }

    function setupDeleteButtons() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = parseInt(this.dataset.id);
                deleteUser(userId);
            });
        });
    }

    function deleteUser(userId) {
        const transaction = db.transaction(['user'], 'readwrite');
        const objectStore = transaction.objectStore('user');
        const request = objectStore.delete(userId);

        request.onsuccess = function(event) {
            console.log('User deleted successfully');
            renderUsers();
        };

        request.onerror = function(event) {
            console.log('Error deleting user: ' + event.target.errorCode);
        };
    }
});
