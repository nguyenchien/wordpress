<div class="wrap-item">
    <?php
        $categories = get_categories();
        $terms = get_terms('products_on_sale_tax');
    ?>
    <h3 class="widget-title"><?php _e('List Category', 'chiennguyen'); ?></h3>
    <ul>
        <?php if ($categories) : ?>
            <?php foreach ($categories as $category): ?>
                <li><a href="/wordpress/<?= LANGUAGE; ?>/category/<?= $category->slug; ?>"><?= $category->name; ?> (<?= $category->category_count; ?>)</a></li>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if ($terms) : ?>
            <?php foreach ($terms as $term): ?>
                <li><a href="/wordpress/<?= LANGUAGE; ?>/products_on_sale_tax/<?= $term->slug; ?>"><?= $term->name; ?> (<?= $term->count; ?>)</a></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>