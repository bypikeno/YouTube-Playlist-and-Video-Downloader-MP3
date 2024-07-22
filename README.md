YouTube Video and Playlist Downloader é uma aplicação web que permite aos usuários baixar vídeos individuais ou playlists completas do YouTube em formatos MP3 e MP4. 
Este projeto oferece uma interface intuitiva e amigável, facilitando a navegação e o uso.

Funcionalidades
Download de Vídeos: Baixe vídeos individuais do YouTube em MP3 ou MP4.
Download de Playlists: Carregue e baixe vídeos de playlists completas do YouTube.
Exibição de Detalhes: Veja miniaturas, títulos, canal, e qualidade do áudio e vídeo dos vídeos.
Botões de Navegação: Navegue facilmente pelos vídeos da playlist com botões numerados.

Tecnologias Utilizadas
HTML: Para a estrutura da página.
CSS: Para a estilização da página.
JavaScript: Para a manipulação de eventos e requisições à API.
Bootstrap: Para a responsividade e componentes visuais.
API Personalizada: Integração com a API personalizada para obter os dados dos vídeos e playlists do YouTube.

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Explicação do Código
Estrutura HTML Básica: Define a estrutura básica da página com o cabeçalho e o corpo, incluindo a integração com o Bootstrap para estilização.

Estilos Personalizados (CSS): Aplica estilos personalizados aos componentes, como entradas de texto, botões, miniaturas de vídeo e contêineres.

Formulário de Entrada:

O formulário permite ao usuário inserir um link do YouTube para baixar um vídeo ou uma playlist.
Dois campos de entrada: um para o link do vídeo e outro para o link da playlist.
Indicador de Carregamento: Mostra uma mensagem de carregamento enquanto os dados são buscados da API.

Manipulação de Eventos (JavaScript):

Submissão do Formulário: Quando o formulário é submetido, faz uma requisição para a API para obter informações sobre o vídeo.
Clique no Botão da Playlist: Quando o botão de carregar playlist é clicado, extrai o ID da playlist da URL fornecida e faz uma requisição para a API para obter os vídeos da playlist.
Funções de Manipulação de Dados:

fetchVideoDetails: Faz uma requisição para obter detalhes de um vídeo específico.
saveButtonState e restoreButtonStates: Salvam e restauram o estado dos botões de playlist usando o sessionStorage.
Este código cria uma interface intuitiva para que os usuários possam baixar vídeos ou playlists do YouTube, exibindo informações relevantes e fornecendo links para download.
