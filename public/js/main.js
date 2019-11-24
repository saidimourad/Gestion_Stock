/*
const utilisateurs = document.getElementById('utilisateurs');
*/
/*
const categories = document.getElementById('categories');
*/
const regions = document.getElementById('regions');
const repas = document.getElementById('repas');
const magasins = document.getElementById('magasins');
const annee_scolaires = document.getElementById('annee_scolaires');
/*
const articles = document.getElementById('articles');
*/
const entrees = document.getElementById('entrees');
const sorties = document.getElementById('sorties');
const commandes=document.getElementById('commandes');


if (entrees) {
    entrees.addEventListener('click', e => {
        if (e.target.className === 'fas fa-trash') {
            //alert(2)
            if (confirm('Voulez-vous vraiment supprimer ?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/entree_delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}


if (commandes) {
    commandes.addEventListener('click', e => {
        if (e.target.className === 'fas fa-trash') {
            //alert(2)
            if (confirm('Voulez-vous vraiment supprimer ?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/commande_delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}

if (sorties) {
    sorties.addEventListener('click', e => {
        if (e.target.className === 'fas fa-trash') {
            //alert(2)
            if (confirm('Voulez-vous vraiment supprimer ?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/sortie_delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}

if (utilisateurs) {
    utilisateurs.addEventListener('click', e => {
        if (e.target.className === 'fas fa-trash') {
            //alert(2)
            if (confirm('Voulez-vous vraiment supprimer ?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/user_delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}


if (article) {
    articles.addEventListener('click', e => {
        if (e.target.className === 'fas fa-trash') {
            //alert(2)
            if (confirm('Voulez-vous vraiment supprimer ?')) {
                const id = e.target.getAttribute('data-id');
               //  alert('/article/2/${id}')
                fetch(`/article/2/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}



if (categories) {
    categories.addEventListener('click', e => {
        if (e.target.className === 'fas fa-trash') {
            //alert(2)
            if (confirm('Voulez-vous vraiment supprimer ?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/categorie/2/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}


if (regions) {
    regions.addEventListener('click', e => {
        if (e.target.className === 'mdi mdi-close') {
            //alert(2)
            if (confirm('Are you sure?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/region/2/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}


if (repas) {
    repas.addEventListener('click', e => {
        if (e.target.className === 'mdi mdi-close') {
            //alert(2)
            if (confirm('Are you sure?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/repas/2/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}


if (magasins) {
    magasins.addEventListener('click', e => {
        if (e.target.className === 'mdi mdi-close') {
            //alert(2)
            if (confirm('Are you sure?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/magasin/2/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}


if (annee_scolaires) {
    annee_scolaires.addEventListener('click', e => {
        if (e.target.className === 'mdi mdi-close') {
            //alert(2)
            if (confirm('Are you sure?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/annee_scolaire/2/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}
