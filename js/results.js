const searchInput = document.getElementById('searchInput');
const resultsDiv = document.getElementById('results');

const fakeResults = [
    { username: 'Usuario1', avatar: 'avatar1.jpg', age: 25, maritalStatus: 'Solteiro' },
    { username: 'Usuario2', avatar: 'avatar2.jpg', age: 30, maritalStatus: 'Casado' },
    { username: 'Usuario3', avatar: 'avatar3.jpg', age: null, maritalStatus: 'Divorciado' },
    { username: 'Usuario4', avatar: 'avatar4.jpg', age: 40, maritalStatus: 'Viúvo' },
    { username: 'Usuario5', avatar: 'avatar5.jpg', age: 22, maritalStatus: 'Solteiro' }
];

searchInput.addEventListener('input', function() {
    const query = searchInput.value.toLowerCase();
    resultsDiv.innerHTML = '';

    if (query) {
        const filteredResults = fakeResults.filter(user => user.username.toLowerCase().includes(query));

        if (filteredResults.length > 0) {
            filteredResults.forEach(user => {
                const div = document.createElement('div');
                div.className = 'result-item';
                div.innerHTML = `
                    <div>
                        <div class="listAvatar">
                            <img src='../images/defaultAvatar.svg'>
                        </div>
                        <div class="listInfo">
                            <span>${user.username} <small>${user.age ? user.age + ' anos, ' : ''}${user.maritalStatus}</small></span>
                        </div>
                    </div>
                    <a href="./profile/${user.username}"><img src='../images/icons/normal/iconNavProfile.svg' class='navGoUser'></a>
                `;
                resultsDiv.appendChild(div);
            });
        } else {
            const div = document.createElement('div');
            div.className = 'no-results';
            div.textContent = 'Nenhum usuário encontrado';
            resultsDiv.appendChild(div);
        }
    }
});