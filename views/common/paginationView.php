<?php
class PaginationView
{
    private $pageItems;
    private $page;
    private $totalItems;
    private $totalPages;
    private $controllerName;
    private $url;

    function __construct($pageItems, $page, $totalItems, $controllerName)
    {
        $this->pageItems = $pageItems;
        $this->page = $page;
        $this->totalItems = $totalItems;
        $this->totalPages = ceil($totalItems / $pageItems);
        $this->controllerName = $controllerName;
        $this->url = "../controllers/". $controllerName . "Controller.php";
        $this->render();
    }

    function render()
    {
        ?>
        <div class="row">
            <?php if ($this->totalItems > 0): ?>
                <!-- Pagination -->
                <label class="label-pagination" data-translate="Elems. por página"></label>
                <select class="form-control items-page" id="items-page-select"
                        onchange="selectChange(this, '<?php echo $this->controllerName ?>')">
                    <option value="10" <?php if ($this->pageItems == 10) echo "selected" ?>>10</option>
                    <option value="25" <?php if ($this->pageItems == 25) echo "selected" ?>>25</option>
                    <option value="50" <?php if ($this->pageItems == 50) echo "selected" ?>>50</option>
                </select>
                <?php if ($this->totalPages > 1): ?>
                    <div class="row">
                        <nav aria-label="...">
                            <ul class="pagination">
                                <?php if ($this->page == 1): ?>
                            <li class="page-item disabled">
                            <?php else: ?>
                                <li class="page-item">
                                    <?php endif; ?>
                                    <a class="page-link"
                                       href="<?php echo $this->url ?>?page=<?php echo $this->page - 1 ?>&pageItems=<?php echo $this->pageItems ?>">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $this->totalPages; $i++): ?>
                                    <?php if ($this->page == $i): ?>
                                        <li class="page-item active">
                                    <?php else: ?>
                                        <li class="page-item">
                                    <?php endif; ?>
                                    <a class="page-link"
                                       href="<?php echo $this->url ?>?page=<?php echo $i ?>&pageItems=<?php echo $this->pageItems ?>">
                                        <?php echo $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                <?php if ($this->page == $this->totalPages): ?>
                                <li class="page-item disabled">
                                    <?php else: ?>
                                <li class="page-item">
                                    <?php endif; ?>
                                    <a class="page-link"
                                       href="<?php echo $this->url ?>?page=<?php echo $this->page + 1 ?>&pageItems=<?php echo $this->pageItems ?>">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
<?php
    }
}
?>