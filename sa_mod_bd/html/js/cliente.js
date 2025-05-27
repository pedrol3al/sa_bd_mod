// Função para aplicar uma máscara de formatação a um input
function aplicarMascara(input, mascara) {
  // Adiciona um ouvinte de evento para quando o usuário digitar no input
  input.addEventListener('input', () => {
    // Remove tudo que não for número do valor digitado (apenas dígitos)
    const numeros = input.value.replace(/\D/g, '');

    let resultado = ''; // Variável para montar o valor formatado
    let index = 0; // Índice para percorrer os números digitados

    // Percorre a máscara e os números ao mesmo tempo
    for (let i = 0; i < mascara.length && index < numeros.length; i++) {
      // Se o caractere da máscara for '#', substitui pelo número correspondente
      if (mascara[i] === '#') {
        resultado += numeros[index++];
      } else {
        // Caso contrário, mantém o caractere da máscara (como pontos, traços, parênteses)
        resultado += mascara[i];
      }
    }

    // Atualiza o valor do input com o texto formatado
    input.value = resultado;
  });
}

// Espera o carregamento completo do DOM para executar
document.addEventListener('DOMContentLoaded', () => {
  // Seleciona os inputs pelo ID
  const cpf = document.getElementById('cpf');
  const rg = document.getElementById('rg');
  const cep = document.getElementById('cep');
  const telefone = document.getElementById('telefone');
  const celular = document.getElementById('celular');

  // Aplica a máscara correta para cada campo, se existir
  if (cpf) aplicarMascara(cpf, '###.###.###-##');       // Máscara CPF: 000.000.000-00
  if (rg) aplicarMascara(rg, '##.###.###-#');           // Máscara RG: 00.000.000-0
  if (cep) aplicarMascara(cep, '#####-###');            // Máscara CEP: 00000-000
  if (telefone) aplicarMascara(telefone, '(##) ####-####'); // Telefone fixo: (00) 0000-0000
  if (celular) aplicarMascara(celular, '(##) #####-####'); // Celular: (00) 00000-0000
});
