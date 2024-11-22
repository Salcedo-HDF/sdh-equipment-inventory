<?php
  $page_title = 'All Image';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);

  // Pagination variables
  $items_per_page = 1;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Fetch total number of media files
  $total_media = count_by_id('media');
  $total_items = $total_media['total'];

  $total_pages = ceil($total_items / $items_per_page);

  // Ensure the current page is within the valid range
  if ($current_page > $total_pages) {
      $current_page = $total_pages;
      $offset = ($current_page - 1) * $items_per_page;
  }

  // Fetch media files with pagination
  $media_files = find_all_media('media', $items_per_page, $offset);

  if (isset($_POST['submit'])) {
    $photo = new Media();
    $photo->upload($_FILES['file_upload']);
    if ($photo->process_media()) {
        $session->msg('s', 'Photo has been uploaded.');
        redirect('media.php');
    } else {
        $session->msg('d', join($photo->errors));
        redirect('media.php');
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
    <div class="col-md-6">
      <?php echo display_msg($msg); ?>
    </div>

    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <span class="glyphicon glyphicon-camera"></span>
          <span>All Photos</span>
          <div class="pull-right">
            <form class="form-inline" action="media.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-btn">
                    <input type="file" name="file_upload" multiple="multiple" class="btn btn-primary btn-file"/>
                  </span>
                  <button type="submit" name="submit" class="btn btn-default">Upload</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center">Photo</th>
                <th class="text-center">Photo Name</th>
                <th class="text-center" style="width: 20%;">Photo Type</th>
                <th class="text-center" style="width: 50px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($media_files as $media_file): ?>
                <tr class="list-inline">
                  <td class="text-center"><?php echo count_id();?></td>
                  <td class="text-center">
                    <img src="uploads/products/<?php echo $media_file['file_name'];?>" class="img-thumbnail" />
                  </td>
                  <td class="text-center">
                    <?php echo $media_file['file_name'];?>
                  </td>
                  <td class="text-center">
                    <?php echo $media_file['file_type'];?>
                  </td>
                  <td class="text-center">
                    <a href="delete_media.php?id=<?php echo (int) $media_file['id'];?>" class="btn btn-danger btn-xs" title="Delete">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </td>
                </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>

        <!-- Pagination Controls -->
        <div class="pagination-controls text-center">
          <ul class="pagination">
              <!-- Previous Page Button -->
              <?php if ($current_page > 1): ?>
                  <li><a href="?page=<?php echo $current_page - 1; ?>">Previous</a></li>
              <?php else: ?>
                  <li class="disabled"><span>Previous</span></li>
              <?php endif; ?>

              <!-- Page Numbers -->
              <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                  <li <?php if ($i == $current_page) echo 'class="active"'; ?>>
                      <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                  </li>
              <?php endfor; ?>

              <!-- Next Page Button -->
              <?php if ($current_page < $total_pages): ?>
                  <li><a href="?page=<?php echo $current_page + 1; ?>">Next</a></li>
              <?php else: ?>
                  <li class="disabled"><span>Next</span></li>
              <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
