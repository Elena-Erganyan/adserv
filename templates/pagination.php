<? if ($pages_count > 1): ?>
    <ul class="pagination__list">
        <li class="pagination__item pagination__item--prev">
            <a href="<? if ($cur_page != 1): ?>
                <?=$address; ?>page=<?=$cur_page - 1; ?>
            <? endif; ?>"><=</a>
        </li>
        <? foreach ($pages as $page): ?>
            <li class="pagination__item <? if ($page == $cur_page): ?>pagination__item--active<? endif; ?>">
                <a href="<?=$address; ?>page=<?=$page; ?>"><?=$page; ?></a>
            </li>
        <? endforeach; ?>
        <li class="pagination__item pagination__item--next">
            <a href="<? if ($cur_page != $pages_count): ?>
                <?=$address; ?>page=<?=$cur_page + 1; ?>
            <? endif; ?>">=></a>
        </li>
    </ul>
<? endif; ?>