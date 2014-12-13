<div class="container">
  <div class="col-md-6 col-md-offset-3">
    <br>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="form" role="form">
          <h4>Test flash messages</h4>
          <hr>
          <div class="form-group">
            <label for="InputName">¿Como te llamas?</label>
            <input type="email" class="form-control" id="InputName" placeholder="Enter your name ...">
            <p class="help-block">
              Escribe tu nombre y utiliza los siguientes botones para probar los distintos
              tipos de mensajes.
            </p>
          </div>
          <hr>
          <div class="form-group">
            <button type="submit" class="btn btn-default" btn-data="normal">Normal</button>
            <button type="submit" class="btn btn-info" btn-data="info">Info</button>
            <button type="submit" class="btn btn-success" btn-data="success">Success</button>
            <button type="submit" class="btn btn-danger" btn-data="danger">Danger</button>
            <button type="submit" class="btn btn-warning" btn-data="warning">Warning</button>
          </div>
          <hr>
          <p>
            Por el momento para usar un <b>flash-message</b> hay que hacer lo siguiente:
          </p>
          <pre>&lt;php \BitPHP\Load::helper('FlashMessages');
  
  //Controlador
  class Testing_flash_helper extends \Helpers\FlashMessages 
  {

    public function index() 
    {
      //Para mostrar un mensaje del tipo informativo
      $this->info('Titulo', 'Contenido del mensaje');
    }
  }       </pre>
          <p>
            Esta característica no esta aún en la descarga de bitphp de la pagina, ya que aún esta
            en <b>beta</b>, esto solo esta disponible en la versión de desarrollo en el repo de 
            <a href="https://github.com/0oeduardoo0/BitPHP">GitHub</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<div id"flash-message"></div>
<script type="text/javascript">
  $(".btn").click(function(){
    var data = $(this).attr("btn-data");
    var name = $("#InputName").val();
    $.get('../testing_flash_helper/show/' + data + '/' + name, function(r){
      $("body").prepend(r);
    });
  });
</script>