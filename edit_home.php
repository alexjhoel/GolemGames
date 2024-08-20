<?php
include_once ("include/connect_session.php");
include_once ("include/definitions.php");

$navSelection = 2;
$access_level_required = ADMIN_REQUIRED;

include ("include/header.php");

$query = "SELECT orden, id_categoria, link_imagen, nombre 
FROM categorias_destacadas 
INNER JOIN categorias 
ON id_categoria = id 
WHERE orden >= 1 AND orden <= 5 
ORDER BY orden ASC";

$popular_cats = mysqli_fetch_all(db::mysqliExecuteQuery($query, "", array()), MYSQLI_ASSOC);

$query = "SELECT id, nombre
FROM categorias 
WHERE borrado = 0";

$cats = mysqli_fetch_all(db::mysqliExecuteQuery($query, "", array()), MYSQLI_ASSOC);

?>

<article class="container px-4 px-md-5 gap-2 flex-fill">

    <section class="text-start py-2">
        <h3 class="ml-0">Editar categorías populares</h3>
        <div class="row gap-2" style="height:300px">
            <a id="category-preview-image-1" class="rounded-5 col-6 col-sm-4 col-md-3 d-flex align-items-end btn img-background position-relative"
                style="background-image: url(<?=$popular_cats[0]["link_imagen"]?>?t=<?=time()?>);">
                <div class="position-absolute top-0 start-0 p-2">
                    <i class="fa-solid fa-1 rounded-circle bg-body px-2 py-1 fs-6"></i>
                </div>
                <h5 class="category-preview-text rounded-5 bg-body p-1"><?=$popular_cats[0]["nombre"]?></h5>
            </a>
            <div class="row col-6 col-sm-4 col-md-3 gap-2">
                <a id="category-preview-image-2" class="rounded-5 col-12 d-flex align-items-end btn img-background position-relative"
                    style="background-image: url(<?=$popular_cats[1]["link_imagen"]?>?t=<?=time()?>);">
                    <div class="position-absolute top-0 start-0 p-2">
                        <i class="fa-solid fa-2 rounded-circle bg-body px-2 py-1 fs-6"></i>
                    </div>
                    <h5 class="category-preview-text rounded-5 bg-body p-1"><?=$popular_cats[1]["nombre"]?></h5>
                </a>
                <a id="category-preview-image-3" class="rounded-5 col-12 d-flex align-items-end btn img-background position-relative"
                    style="background-image: url(<?=$popular_cats[2]["link_imagen"]?>?t=<?=time()?>);">
                    <div class="position-absolute top-0 start-0 p-2">
                        <i class="fa-solid fa-3 rounded-circle bg-body px-2 py-1 fs-6"></i>
                    </div>
                    <h5 class="category-preview-text rounded-5 bg-body p-1"><?=$popular_cats[2]["nombre"]?></h5>
                </a>
            </div>
            <a id="category-preview-image-4" class="rounded-5 d-none d-sm-flex col-4 col-md-3 align-items-end btn img-background position-relative"
                style="background-image: url(<?=$popular_cats[3]["link_imagen"]?>?t=<?=time()?>);">
                <div class="position-absolute top-0 start-0 p-2">
                    <i class="fa-solid fa-4 rounded-circle bg-body px-2 py-1 fs-6"></i>
                </div>
                <h5 class="category-preview-text rounded-5 bg-body p-1"><?=$popular_cats[3]["nombre"]?></h5>
            </a>
            <a id="category-preview-image-5" class="rounded-5 col-3 d-none d-md-flex align-items-end btn img-background position-relative"
                style="background-image: url(<?=$popular_cats[4]["link_imagen"]?>?t=<?=time()?>);">
                <div class="position-absolute top-0 start-0 p-2">
                    <i class="fa-solid fa-5 rounded-circle bg-body px-2 py-1 fs-6"></i>
                </div>
                <h5 class="category-preview-text rounded-5 bg-body p-1"><?=$popular_cats[4]["nombre"]?></h5>
            </a>
        </div>
    </section>


    <form action="php_tasks/popular_categories_save.php" method="post" enctype="multipart/form-data" class="d-flex flex-column p-3 gap-3 rounded-4 border">
        <?php for ($i = 1; $i <= 5; $i++){ ?>
            <div class="input-group dropdown ">
                <div class="px-3 pb-2 pt-2"><i class="fa-solid fa-<?=$i?>"></i></div>
                <input id="category-name-input-<?=$i?>" type="text" value="<?=$popular_cats[$i - 1]["nombre"]?>" class="form-control category-name-input">
                <button type="button"
                    class="btn btn-primary dropdown-toggle dropdown-toggle-split category-toggler" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <button class="btn btn-success rounded-end" type="button" onclick="$(this).siblings('.file-upload').click()"><i class="fa-solid fa-image"></i></button>
                <ul class="dropdown-menu dropdown-menu-end w-100" data-id=<?=$i?>>
                    <?php foreach ($cats as $cat) { ?>
                        <li>
                            <a class="dropdown-item category-select-option" data-id="<?= $cat["id"] ?>"><?= $cat["nombre"] ?></a>
                        </li>
                    <?php } ?>
                </ul>
                <input id="category-id-input-<?=$i?>" name="id_categoria_popular_<?=$i?>" value="<?=$popular_cats[$i - 1]["id_categoria"]?>" hidden>
                <input name="imagen_categoria_popular_<?=$i?>" class="d-none file-upload" data-id=<?=$i?> type="file" accept="image/*" onchange="" hidden>
            </div>
        <?php } ?>
        <button class="btn btn-success rounded-5"><i class="fa-solid fa-save"></i>&nbsp;Guardar</button>
    </form>

    <h3 class="ml-0">Editar categorías</h3>

    <form id="edit-categories" action="php_tasks/categories_save.php" method="post" class="d-flex flex-column p-3 gap-3 rounded-4 border">
        <?php foreach($cats as $cat){ ?>
        <div class="input-group">
            <input name="nombre[]" value="<?=$cat["nombre"]?>" class="form-control" type="text">
            <input name="id[]" value="<?=$cat["id"]?>" class="form-control" type="text"  hidden >
            <button class="btn btn-danger" name="delete" value=<?=$cat["id"]?> ><i class="fa-solid fa-trash"></i></button>
        </div>
        <?php }?>
        <div class="d-flex gap-2">
            <button name="action" value="add"  type="submit" class="btn btn-info rounded-5 flex-fill"><i class="fa-solid fa-plus"></i>&nbsp;Nueva categoría</button>
            <button name="action" value="save" type="submit" class="btn btn-success rounded-5 flex-fill"><i class="fa-solid fa-save"></i>&nbsp;Guardar</button>
        </div>
    </form>

</article>



<?php
include ("include/footer.php");
?>

<script>
    function showOptions(element, toggle) {

        if (toggle) {
            new bootstrap.Dropdown(element.siblings(".dropdown-toggle")).show();
            element.focus();
        }

        var searchVal = element.val();
        element.siblings(".dropdown-menu").children().each(function (i) {
            if (isStringIncluded($(this).children("a").html(), searchVal.toLowerCase())) {
                $(this).removeAttr("hidden");
            } else {
                $(this).attr("hidden", true);
            }
        })
    }



    $(".category-name-input").on("keyup", function () {
        showOptions($(this), true)
    })

    $(".category-toggler").on("click", function () {
        showOptions($(this), false)
    })


    $(".category-select-option").click(function () {
        const id = $(this).parent().parent().attr("data-id");
        $("#category-name-input-" + id).val($(this).html())
        $("#category-preview-image-" + id).children(".category-preview-text").html($(this).html())
        $("#category-id-input-" + id).val($(this).attr("data-id"))
    })


    function isStringIncluded(mainString, searchString) {
        // Convert both strings to lowercase for case-insensitive comparison
        mainString = mainString.toLowerCase();
        searchString = searchString.toLowerCase();

        // Check if the mainString includes the searchString
        return mainString.includes(searchString);
    }

    $(".file-upload").on('change', function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            var previewImage = $("#category-preview-image-" + $(this).attr("data-id"));
            reader.onloadend = function (e) {
                previewImage.css("background-image", "url(" + reader.result + ")");
            }
                                    
            reader.readAsDataURL(this.files[0]);
        }
    });


</script>