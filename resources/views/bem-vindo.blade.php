@auth
    <h1>Usuario autenticado:</h1>
    <p>ID {{Auth::user()->id}}</p>
    <p>Nome {{Auth::user()->name}}</p>
    <p>Email {{Auth::user()->email}}</p>
@endauth

@guest
    Ola visitante, tudo bem</br>
    .</br>
    . </br>
    . </br>
    . </br>
    . </br> 
@endguest