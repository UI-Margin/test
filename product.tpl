{**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2018 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name='product_miniature_item'}
  <article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
    <div class="thumbnail-container">
      {block name='product_thumbnail'}
        {if $product.cover}
          <a href="{$product.url}" class="thumbnail product-thumbnail">
            <img
              src = "{$product.cover.bySize.home_default.url}"
              alt = "{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
              data-full-size-image-url = "{$product.cover.large.url}"
            >
          </a>
        {else}
          <a href="{$product.url}" class="thumbnail product-thumbnail">
            <img
              src = "{$urls.no_picture_image.bySize.home_default.url}"
            >
          </a>
        {/if}
      {/block}

      <div class="product-description">
        {block name='product_name'}
          {if $page.page_name == 'index'}
            <h3 class="h3 product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:30:'...'}</a></h3>
          {else}
            <h2 class="h3 product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:30:'...'}</a></h2>
          {/if}
        {/block}

        {block name='product_price_and_shipping'}
          {if $product.show_price}
            <div class="product-price-and-shipping">
				{if $product.discount_type === 'percentage'}
				<div class="sale">
					<span>sale</span>
				</div>
				{elseif $product.discount_type === 'amount'}
				<span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
				{/if}
              {hook h='displayProductPriceBlock' product=$product type="before_price"}

              <span class="sr-only">{l s='Price' d='Shop.Theme.Catalog'}</span>
              <span itemprop="price" class="price">{$product.price}</span>

              {hook h='displayProductPriceBlock' product=$product type='unit_price'}

              {hook h='displayProductPriceBlock' product=$product type='weight'}

              {if $product.has_discount}
                {hook h='displayProductPriceBlock' product=$product type="old_price"}
                
                <span class="sr-only">{l s='Regular price' d='Shop.Theme.Catalog'}</span>
                <span class="regular-price">{$product.regular_price}</span>
              {/if}
            </div>
          {/if}
        {/block}

        {block name='product_reviews'}
          {hook h='displayProductListReviews' product=$product}
        {/block}
      </div>

      {block name='product_flags'}
        <ul class="product-flags-news">
          {foreach from=$product.flags item=flag}
            <li class="{$flag.type}">{$flag.label}</li>
          {/foreach}
        </ul>
      {/block}

      	<div class="highlighted-informations hidden-sm-down">
			{block name='quick_view'}
			<a class="quick-view" href="#" data-link-action="add-to-cart">
				<i class="material-icons">shopping_cart</i>
			</a>
			<a class="quick-view" href="#" data-link-action="quickview">
				<i class="material-icons">remove_red_eye</i>
			</a>
			<a class="quick-view" href="#" data-link-action="quickview">
				<i class="material-icons">favorite</i>
			</a>
        	{/block}
      	</div>
	</div>
	<div class="star-block">
		<div id="Stars">
			<input id="star-4" type="radio" name="Stars" />
			<label title="gorgeous" for="star-4"></label>
	
			<input id="star-3" type="radio" name="Stars" />
			<label title="good" for="star-3"></label>
	
			<input id="star-2" type="radio" name="Stars" />
			<label title="regular" for="star-2"></label>
	
			<input id="star-1" type="radio" name="Stars" />
			<label title="poor" for="star-1"></label>
	
			<input id="star-0" type="radio" name="Stars" />
			<label title="bad" for="star-0"></label>
		</div>
	</div>
  </article>
{/block}
