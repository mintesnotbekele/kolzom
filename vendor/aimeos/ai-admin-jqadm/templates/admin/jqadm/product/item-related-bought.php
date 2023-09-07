<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2023
 */

$enc = $this->encoder();

$keys = [
	'product.lists.id', 'product.lists.siteid', 'product.lists.refid', 'product.label', 'product.code'
];


?>
<div class="col-xl-6 item-related-bought">

	<div class="box">
		<table class="product-list table table-default"
			data-items="<?= $enc->attr( $this->get( 'boughtData', [] ) ) ?>"
			data-keys="<?= $enc->attr( $keys ) ?>"
			data-prefix="product.lists."
			data-siteid="<?= $this->site()->siteid() ?>" >

			<thead>
				<tr>
					<th>
						<span class="help"><?= $enc->html( $this->translate( 'admin', 'Products bought together' ) ) ?></span>
						<div class="form-text text-muted help-text">
							<?= $enc->html( $this->translate( 'admin', 'List of products often bought together' ) ) ?>
						</div>
					</th>
					<th class="actions">
						<div class="btn act-add fa" tabindex="<?= $this->get( 'tabindex' ) ?>"
							title="<?= $enc->attr( $this->translate( 'admin', 'Insert new entry (Ctrl+I)' ) ) ?>"
							v-on:click="add()">
						</div>
					</th>
				</tr>
			</thead>

			<tbody is="draggable" v-model="items" group="related" handle=".act-move" tag="tbody">

				<tr v-for="(item, idx) in items" v-bind:key="idx"
					v-bind:class="item['product.lists.siteid'] != `<?= $enc->js( $this->site()->siteid() ) ?>` ? 'readonly' : ''">
					<td v-bind:class="(item['css'] || '')">
						<input class="item-listid" type="hidden" v-model="item['product.lists.id']"
							v-bind:name="`<?= $enc->js( $this->formparam( ['related', 'bought', '_idx_', 'product.lists.id'] ) ) ?>`.replace( '_idx_', idx )">

						<input class="item-refid" type="hidden" v-model="item['product.lists.refid']"
							v-bind:name="`<?= $enc->js( $this->formparam( ['related', 'bought', '_idx_', 'product.lists.refid'] ) ) ?>`.replace( '_idx_', idx )">

						<Multiselect class="item-id"
							placeholder="Enter product ID, code or label"
							value-prop="product.id"
							track-by="product.id"
							label="product.label"
							@open="load"
							@input="use(idx, $event)"
							:value="item"
							:title="title(idx)"
							:readonly="!can('change', idx)"
							:options="async function(query) {return await fetch(query, idx)}"
							:resolve-on-load="false"
							:filter-results="false"
							:can-deselect="false"
							:allow-absent="true"
							:searchable="true"
							:can-clear="false"
							:required="true"
							:min-chars="1"
							:object="true"
							:delay="300"
						></Multiselect>
					</td>
					<td class="actions">
						<div v-if="can('move', idx)"
							class="btn btn-card-header act-move fa" tabindex="<?= $this->get( 'tabindex' ) ?>"
							title="<?= $enc->attr( $this->translate( 'admin', 'Move this entry up/down' ) ) ?>">
						</div>
						<div v-if="can('delete', idx)"
							class="btn act-delete fa" tabindex="<?= $this->get( 'tabindex' ) ?>"
							title="<?= $enc->attr( $this->translate( 'admin', 'Delete this entry' ) ) ?>"
							v-on:click.stop="remove(idx)">
						</div>
					</td>
				</tr>

			</tbody>
		</table>
	</div>

	<?= $this->get( 'boughtBody' ) ?>
</div>
