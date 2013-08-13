<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($articles as $article): ?>
    <url>
        <loc>http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $article['Article']['full_url']; ?></loc>
        <lastmod><?php echo $this->Time->toAtom($article['Article']['modified']); ?></lastmod>
        <changefreq>weekly</changefreq>
    </url>
    <?php endforeach; ?>
</urlset>