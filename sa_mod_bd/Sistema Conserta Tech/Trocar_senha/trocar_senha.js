//Função para conferir se os campos estão preenchidos
function conferirCampos() {
    var email = document.getElementById('email'); //Cria a varivael nome puxa seu Id
    var senha_nova = document.getElementById('senha_nova') //Cria a varivael senha e puxa seu Id

    const notyf = new Notyf({ //Criação de uma varivael global para a mensagem, podendo reutilizar em outros trechos
        position: { x: 'center', y: 'top' }
    });


    if (!email || email.value.trim() === "") { //Se a variavel nome não existir (! garante isso), OU, se o valor digitado, sem contar os espaços for vazio
        notyf.error('Campo de email deve ser preenchido!');   //Exibe a mensagem de erro pois o campo está vazio
        return false; //Impede que os dados do formulario sejam enviados, caso não estivesse aqui, apareceria a mensagem, mas os dados seriam enviados
    }

    if (!senha_nova || senha_nova.value.trim() === "") {
        notyf.error('Campo senha deve ser preenchido')
        return false;
    } else {

        notyf.success('Senha alterada com sucesso')

        setTimeout(() => {
            window.location.href = "main.html";
        }, 2000);
        return true; //Caso os campos sejam preenchidos, continua
    }
}