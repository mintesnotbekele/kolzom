<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2023
 */

$enc = $this->encoder();


?>
<title>
Kolzom</title>
<meta name="description" content="<?= $enc->attr( $this->get( 'contextSiteLabel', 'Aimeos' ) ) ?>">

<link rel="stylesheet" href="<?= $enc->attr( $this->content( $this->get( 'contextSiteTheme', 'default' ) . '/summary.css', 'fs-theme', true ) ) ?>">
<link rel="stylesheet" href="<?= $enc->attr( $this->content( $this->get( 'contextSiteTheme', 'default' ) . '/checkout-confirm.css', 'fs-theme', true ) ) ?>">
<script defer src="<?= $enc->attr( $this->content( $this->get( 'contextSiteTheme', 'default' ) . '/checkout-confirm.js', 'fs-theme', true ) ) ?>"></script>
