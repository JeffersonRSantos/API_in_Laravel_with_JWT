<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Access_token</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container"><a class="navbar-brand" href="#">GET Access_Token</a></div>        
      </nav>

      <div class="container">
        <div class="row">
          <div class="col col-lg-6">
              <div class="card">
                  <div class="card-body">
                      <h4>Gerar novo Access Token</h4>
                      <hr>
                      <small class="obs-small">Insira suas credencias para gerar um novo Access Token de acesso a API.</small>
                        <form id="form_get_access_token" name="form_access_token">
                            <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <hr>
                            <small>Não tem acesso? <a href="{{ route('register') }}">Registrar</a></small>
                            <button type="submit" class="btn btn-outline-secondary btn-block btn-send">Solicitar Token</button>
                        </form>
                    </div>
                </div><br>

                <div class="card theme-green view-token" style="width: 100%;">
                    <div class="card-body">
                        <p>Token gerado:</p>
                        <p class="my-token"></p>
                        <p>obs: Seu token expira em 60 minutos.</p>                         
                    </div>
                </div><br>
                <button type="button" class="btn btn-outline-success btn-block btn-get-dados">Solicitar dados API</button>
          </div>
          <div class="col col-lg-6">            
            <div class="alert alert-danger alert-error" role="alert"></div>
            <div class="alert alert-success alert-check" role="alert"></div>
            <div class="card view-access-token" style="width:100%">
                <div class="card-body">
                    <p id="resp"></p>
                </div>
              </div>
              
              <!-- data API -->
              <div class="card dados-api-container" style="width: 100%;">
                <div class="card-body">
                    <h4>Dados da API</h4>
                    <p class="dados-api"></p>
                </div>
            </div>
          </div>          
        </div>
      </div>

      <script>
          //hide
          $('.view-access-token, .dados-api-container, .btn-get-dados, .alert-check, .alert-error, .view-token').hide();
          //
          $(function(){
              //GET Access Token
            $('form[name="form_access_token"]').submit( function(e){
                
                $.ajax({
                    url: '{{ route("auth.login") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    success: function(response){
                        //guarda o token gerado
                        localStorage.setItem('token', response.access_token);
                        //mostra na tela ao usuário
                        $('.view-access-token').fadeIn(800).show().fadeOut(5000);
                        $('#resp').html('access_token: '+ response.access_token + '<br>' + 
                        'token_type: ' + response.token_type + '<br>' + 
                        'expires_in: ' + response.expires_in + 'guarde a chave para não esquecer. <br>');
                        $('.btn-send').html('Solicitar outro Token');
                        //mostra o token gerado
                        if(localStorage.getItem('token') !== ''){
                            $('.view-token').show();
                            $('.my-token').html(localStorage.getItem('token'));
                            $('.btn-get-dados').show();
                        }
                    },
                    beforeSend: function(response){
                        $('.btn-send').html('Carregando...');
                    },
                    error: function(response){
                        $('.dados-api,.my-token').hide();
                        $('.alert-error').show().html(response.responseJSON.error).fadeOut(5000);
                        $('.btn-send').html('Tentar novamente');
                    },
                });
                e.preventDefault();
            });

                       

            //GET data API  
            $('.btn-get-dados').on('click', function(e){
                $.ajax({
                    url: "{{ route('dashboard.produtos') }}",
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    type: 'get',
                    dataType: 'html',
                    success: function(data){
                        $('.dados-api-container').show();
                        $('.dados-api').html(data);
                        $('.alert-check').show().html('Token validado com sucesso!').fadeOut(6000);
                    },
                    error: function(data){
                        $('.alert-error').fadeIn(2000).show().html('Erro ao trazer os dados!').fadeOut(7000);
                    },
                });
                e.preventDefault();
            });            
          });
      </script>
</body>
</html>