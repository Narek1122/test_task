<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="alert alert-danger" role="alert" style="display: none">

    </div>

    <div class="container" id="main">
        <section class="vh-100">
            <div class="container py-5 h-100">
              <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                  <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                    <div class="card-body py-4 px-4 px-md-5">

                      <p class="h1 text-center mt-3 mb-4 pb-3 text-primary">
                        <u>Test Task</u>
                      </p>

                      <div class="pb-2">
                        <div class="card">
                          <div class="card-body">
                            <div class="d-flex flex-row align-items-center">
                              <input type="text" class="form-control form-control-lg" id="post_input"
                                placeholder="Add new...">
                              <div>
                                <button type="button" class="btn btn-primary" onclick="store()">Add</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <hr class="my-4">
                      <div id="list_div">

                      </div>
                      {{-- <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
                        <p class="small mb-0 me-2 text-muted">Filter</p>
                        <select class="select">
                          <option value="1">All</option>
                          <option value="2">Completed</option>
                          <option value="3">Active</option>
                          <option value="4">Has due date</option>
                        </select>
                        <p class="small mb-0 ms-4 me-2 text-muted">Sort</p>
                        <select class="select">
                          <option value="1">Added date</option>
                          <option value="2">Due date</option>
                        </select>
                        <a href="#!" style="color: #23af89;" data-mdb-toggle="tooltip" title="Ascending"><i
                            class="fas fa-sort-amount-down-alt ms-2"></i></a>
                      </div> --}}


                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
    </div>
  </body>
  <script>
    let token = '';

    function generateDiv(data){
        return `<ul class="list-group list-group-horizontal rounded-0 bg-transparent post_${data.id}">
                        <li
                          class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded-0 border-0 bg-transparent">
                          <div class="form-check">
                            <button class="btn btn-sm" onclick="destroy(${data.id})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                          </div>
                        </li>
                        <li
                          class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 border-0 bg-transparent">
                          <p class="lead fw-normal mb-0 post_text_${data.id}">${data.name}</p>
                          <input type="text" class="form-control post_inp_${data.id}" value="${data.name}" style="display:none">
                        </li>
                        <li class="list-group-item ps-3 pe-0 py-1 rounded-0 border-0 bg-transparent">
                            <div class="d-flex flex-row justify-content-end mb-1">
                                <a onclick="update(${data.id})"  class="text-info" data-mdb-toggle="tooltip" aria-label="Edit todo" data-mdb-original-title="Edit todo"><i class="fas fa-pencil-alt me-3"></i></a>
                            </div>
                        </li>
                      </ul>`
    }

    function appendData(data){
        const list_div = document.getElementById('list_div');
        list_div.insertAdjacentHTML('beforeend', generateDiv(data));
    }
    async function promToken(){
        token = prompt("Enter your token here");
        const response = await fetch('/api/post', {
            method: 'GET',
            headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
            },
        });
        if(response.status == 401){
            alert("Invalid Token");
            promToken()
        }
        const res = await response.json()
        if(res.posts.length){
            for(let p=0;p<res.posts.length;p++){
            appendData(res.posts[p])
            }
        }

    }

    async function destroy(id){
        const response = await fetch(`/api/post/${id}`, {
            method: 'DELETE',
            headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
            },
        });
        if(response.status == 200){
            const el =  document.querySelector('.post_'+id);
            el.remove()
        }

    }

    function clearErrors(){
        setTimeout(() => {
            const errorDiv = document.querySelector('.alert-danger');
            errorDiv.style.display = 'none'
            errorDiv.innerHTML = '';
        }, 3000);
    }

    async function store(){
        const postInput = document.getElementById('post_input');
        const response = await fetch(`/api/post`, {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({name:postInput.value})

        });

        const res = await response.json()
        if(response.status == 422){
            const errorDiv = document.querySelector('.alert-danger');
            errorDiv.style.display = 'block'
            errorDiv.insertAdjacentHTML('beforeend', `<p>${res['name']}</p>`);
            clearErrors()
        }

        appendData(res.data);
        postInput.value = '';


    }

    async function update(id){
        const postText = document.querySelector('.post_text_' + id);
        const postInp = document.querySelector('.post_inp_' + id);

        console.log(postText)

        if(postText.style.display == 'none'){
            postText.style.display = 'block'
            postInp.style.display = 'none'
        }else{
            postText.style.display = 'none'
            postInp.style.display = 'block'
        }

        if(postText.innerHTML != postInp.value){
            const response = await fetch(`/api/post/${id}`, {
            method: 'PATCH',
            headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({name:postInp.value})

            });

        const res = await response.json()

        if(response.status == 422){
            const errorDiv = document.querySelector('.alert-danger');
            errorDiv.style.display = 'block'
            errorDiv.insertAdjacentHTML('beforeend', `<p>${res['name']}</p>`);
            clearErrors()

            postInp.value = postText.innerHTML
        }

        postText.innerHTML = postInp.value



        }

    }
    promToken()

  </script>
</html>
