const employes = document.getElementById('employes');

if (employes) {
  employes.addEventListener('click', e => {
    if (e.target.className === 'btn btn-danger delete-article') {
      //alert(2)
      if (confirm('Are you sure?')) {
        const id = e.target.getAttribute('data-id');

       fetch(`/employe/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload());
      }
    }
  });
}
