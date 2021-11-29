<div class="navbar-fixed">
  <nav class="nav-extended white">
    <div class="nav-wrapper white">
      <ul>
        <li><a href="<?= URL_RAIZ . 'drive'?>" class="title grey-text text-darken-1">PHP Drive</a></li>
        <li class="title grey-text text-darken-1">| <?= $fullName ?> </li>
        <li>
          <div class="search-wrapper">
            <i class="material-icons">search</i>
            <input type="search" name="Search" placeholder="Search Drive" />
          </div>
        </li>
      </ul>
      <ul class="right">
        <li><img src="<?= $profilePhoto ?>" class="circle"></li>
        <li>
          <a href="#" onclick="$('#logout').submit()">
            <i class="material-icons grey-text text-darken-1 btn-logout">logout</i>
          </a>
          <form id="logout" action="<?= URL_RAIZ . 'login' ?>" method="POST" class="hidden">
            <input type="hidden" name="_metodo" value="DELETE">
          </form>
        </li>
      </ul>
    </div>

    <div class="nav-wrapper">
      <ul>
        <li>
          <form action="<?= URL_RAIZ . 'drive'?>" id="upload-file" method="POST" enctype="multipart/form-data">
            <div class="file-field input-field valign-wrapper">
              <div class="btn blue">
                <span>New</span>
                <input type="file" name="file" id="file">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
            </div>
          </form>
        </li>
        <li>
          <button type="submit" class="btn blue" form="upload-file">Submit</button>
        </li>
      </ul>
    </div>
  </nav>
</div>

<ul class="side-nav fixed floating transparent z-depth-0">
  <li class="active"><a href="<?= URL_RAIZ . 'drive'?>"><i class="material-icons blue-text text-darken-1">dashboard</i>My Drive</a>
  </li>
</ul>

<div class="main">
  <div class="container-fluid" id="drop-area">
    <table class="highlight bordered">
      <thead>
        <tr>
          <th>
            Name
            <button class="btn-flat waves-effect order-by-name">
              <i class="material-icons">arrow_upward</i>
            </button>
          </th>

          <th>
            Owner
          </th>

          <th>
            Upload Date
            <button class="btn-flat waves-effect order-by-time">
              <i class="material-icons">arrow_upward</i>
            </button>
          </th>

          <th>
            File Size
            <button class="btn-flat waves-effect order-by-size">
              <i class="material-icons">arrow_upward</i>
            </button>
          </th>
        </tr>
      </thead>
      <?php if (empty($arquivos)) : ?>
        <tr>
          <td colspan="99" class="center-align">No files found in your database</td>
        </tr>
      <?php endif ?>

      <?php foreach ($arquivos as $arquivo) : ?>
        <tbody id="tbody">
          <tr>
            <td><i class="material-icons red600 left">movie</i><?= $arquivo->getName()?></td>
            <td><?= $fullName ?></td>
            <td><?=$arquivo->getUploadDate()?></td>
            <td><?= ceil($arquivo->getSize()/1024) . ' KB'?></td>

            <td>
              <form action="../../../public/pages/comments.php" method="POST">
                <input type='hidden' name='id' value='1'>
                <button type="submit" class="btn-flat"><i class="material-icons btn-comment">comment</i></button>
              </form>
            </td>
            <td><i class="material-icons left btn-download">download</i></td>
            <td><i class="material-icons left btn-delete">delete</i></td>
          </tr>
          <!-- <tr>
            <td><i class="material-icons left">content_copy</i> php-no-lado-servidor.pdf</td>
            <td>system_user</td>
            <td>27 de agosto de 2021 14:11</td>
            <td>1 GB</td>
            <td>
              <form action="../../../public/pages/comments.php" method="POST">
                <input type='hidden' name='id' value='2'>
                <button type="submit" class="btn-flat"><i class="material-icons btn-comment">comment</i></button>
              </form>
            </td>
            <td><i class="material-icons left btn-download">download</i></td>
            <td><i class="material-icons left btn-delete">delete</i></td>
          </tr>
          <tr>
            <td><i class="material-icons yellow600 left">image</i> carlos-009997774.jpg</td>
            <td>system_user</td>
            <td>27 de agosto de 2021 14:12</td>
            <td>5 MB</td>
            <td>
              <form action="../../../public/pages/comments.php" method="POST">
                <input type='hidden' name='id' value='3'>
                <button type="submit" class="btn-flat"><i class="material-icons btn-comment">comment</i></button>
              </form>
            </td>
            <td><i class="material-icons left btn-download">download</i></td>
            <td><i class="material-icons left btn-delete">delete</i></td>
          </tr> -->
        </tbody>
      <?php endforeach ?>
    </table>
  </div>
</div>