<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'automattus' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'kvNOm}GyFa.q_^eR$Rgb}@ePQ+#SeyVj+|sAaVkwT u0vn78Y@R7p|de}|/3ETyg' );
define( 'SECURE_AUTH_KEY',  'zDT~=AuM/}(p[|WF-2J#k&i;xuRjwdye. v jkxPk>[Eo<8uNJ#R3x53n~3sL-~0' );
define( 'LOGGED_IN_KEY',    'Fy/#U;!myt=qTqR:ZgB26]^ho3Iy6$i+>s4guXNb58V}BfB9ux{Eek$S#8ahne&y' );
define( 'NONCE_KEY',        '8,IdA5EYz]RC2#_m!1OVL,^(Lvs*N:Bpw/CaAo]=|^4wP/Y@cMhER;R((@<FJOci' );
define( 'AUTH_SALT',        ',i^.Z sQfuX;-yxhM8 Qc;@u,?_2-X$68CT|XY+Kl!n]jS$mwsdDvn7%t$_{tDXM' );
define( 'SECURE_AUTH_SALT', '3?:I2P0j8OUJ#Jy>5`no8j_EA))Y6V<blZE1fq3AzE._6dh<(q^Xy*{ozjfWoO&a' );
define( 'LOGGED_IN_SALT',   'A/kS&Ex)@ZBXQ~K<)h:m8/4&@|:,?shqkiA2,.OC}-9p>>dB6$wS>,f^*=Z+OPF+' );
define( 'NONCE_SALT',       '#P(GrM3(+ra@1G$63V#yWj:K%dxQqMv?y)i0K99U(/ i(%%2$sVxpH&Qf>5#.+I3' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
