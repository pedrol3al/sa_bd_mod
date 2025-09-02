document.addEventListener("DOMContentLoaded", function () {
  // Calendário para data de nascimento
// Calcula a data limite para 16 anos
const hoje = new Date();
const anoMinimo = hoje.getFullYear() - 16;
const mes = String(hoje.getMonth() + 1).padStart(2, '0');
const dia = String(hoje.getDate()).padStart(2, '0');
const dataMaxima = `${anoMinimo}-${mes}-${dia}`;

flatpickr("#data_nasc", {
    dateFormat: "Y-m-d",  // formato compatível com MySQL
    maxDate: dataMaxima,  // somente datas até 16 anos atrás
});

  
  flatpickr("#data_cad", {
      dateFormat: "Y-m-d",
      maxDate: "today"
  });
  
  const notyf = new Notyf({
      position: { x: 'center', y: 'top' }
  });

  function conferirCampos() {
      const camposObrigatorios = [
          { id: 'nome_cliente', nome: 'Nome do cliente'},
          { id: 'id_usuario', nome: 'Id do usuário' },
          { id: 'email_cliente', nome: 'Email' },
          { id: 'cpf_cliente', nome: 'CPF' },
          { id: 'dataNascimento', nome: 'Data de Nascimento' },
          { id: 'sexo_cliente', nome: 'Sexo' },
          { id: 'telefone_cliente', nome: 'Telefone' },
          { id: 'cep_cliente', nome: 'CEP' },
          { id: 'logradouro_cliente', nome: 'Logradouro' },
          { id: 'tipo_casa', nome: 'Tipo de moradia' },
          { id: 'uf_cliente', nome: 'Estado (UF)' },
          { id: 'numero_cliente', nome: 'Número' },
          { id: 'cidade_cliente', nome: 'Cidade' },
          { id: 'bairro_cliente', nome: 'Bairro' },
      ];

      for (let campo of camposObrigatorios) {
          const elemento = document.getElementById(campo.id);
          if (elemento && elemento.value.trim() === '') {
              notyf.error(`O campo "${campo.nome}" é obrigatório!`);
              elemento.focus();
              return false;
          }
      }

      notyf.success(`Cliente cadastrado!`);
      return true;
  }

  // Máscaras
  $(document).ready(function () {
      $('#cpf_cliente').mask('000.000.000-00');
      $('#telefone_cliente').mask('(00) 00000-0000');
      $('#cep_cliente').mask('00000-000');
  });

  // Expor função para botão
  window.conferirCampos = conferirCampos;
});

// Abrir modal ao clicar no botão "Pesquisar"
document.getElementById('pesquisar').addEventListener('click', function() {
  document.getElementById('modal-pesquisa').style.display = 'flex';
});

// Fechar modal
document.getElementById('fechar-modal').addEventListener('click', function() {
  document.getElementById('modal-pesquisa').style.display = 'none';
});

// Fechar clicando fora do modal
window.addEventListener('click', function(event) {
  const modal = document.getElementById('modal-pesquisa');
  if(event.target === modal) {
    modal.style.display = 'none';
  }
});