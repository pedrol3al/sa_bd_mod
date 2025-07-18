//Função para conferir se os campos estão preenchidos
function conferirCampos() {
    var nome = document.getElementById('nome'); //Cria a varivael nome puxa seu Id
    var senha = document.getElementById('senha') //Cria a varivael senha e puxa seu Id

    const notyf = new Notyf({ //Criação de uma varivael global para a mensagem, podendo reutilizar em outros trechos
        position: { x: 'center', y: 'top' }
      });
       

    if (!nome || nome.value.trim() === "")  { //Se a variavel nome não existir (! garante isso), OU, seo valor digitado, sem contar os espaços for vazio
        notyf.error('Campo de nome deve ser preenchido!');   //Exibe a mensagem de erro pois o campo está vazio
        return false; //Impede que os dados do formulario sejam enviados, caso não estivesse aqui, apareceria a mensagem, mas os dados seriam enviados
    }

    if(!senha || senha  .value.trim() === ""){
        notyf.error('Campo senha deve ser preenchido')
        return false;
    }else{
        document.getElementById("logar")?.addEventListener("click", () => {
            window.location.href = "../Agenda/agenda.html";
          });

          return true; //Caso os campos sejam preenchidos, continua
    }
}


