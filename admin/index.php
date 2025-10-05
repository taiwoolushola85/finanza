<?php include 'header.php'; ?>


<div class="row">
<div class="col-xl-4 col-md-4 col-sm-4">
<div class="card">
<div class="card-body">
<div>
<h5 class="text-uppercase">Total User's</h5>
</div>
<div class="mb-3">
<canvas id="promptsChart" height="60"></canvas>
</div>
<div class="d-flex justify-content-between">
<div>
<span class="text-muted">Active User</span>
<div class="fw-semibold"><span data-target="1,245">0</span></div>
</div>
<div class="text-end">
<span class="text-muted">Non-Active</span>
<div class="fw-semibold"><span data-target="1,110">0</span> <i class="ti ti-arrow-down"></i></div>
</div>
</div>


</div>
</div>
</div>
<div class="col-xl-4 col-md-4 col-sm-4">
<div class="card">
<div class="card-body">
<div>
<h5 class="text-uppercase">Total Branch</h5>
</div>
<div class="mb-3">
<canvas id="tokenChart" height="60"></canvas>
</div>
<div class="d-flex justify-content-between">
<div>
<span class="text-muted">Active Branch</span>
<div class="fw-semibold"><span data-target="1,245">0</span></div>
</div>
<div class="text-end">
<span class="text-muted">Non-Branch</span>
<div class="fw-semibold"><span data-target="1,110">0</span> <i class="ti ti-arrow-down"></i></div>
</div>
</div>



</div>
</div>
</div>
<div class="col-xl-4 col-md-4 col-sm-4">
<div class="card">
<div class="card-body">
<div>
<h5 class="text-uppercase">Total Role</h5>
</div>
<div class="mb-3">
<canvas id="accuracyChart" height="60" width="120"></canvas>
</div>
<div class="d-flex justify-content-between">
<div>
<span class="text-muted">Active Role</span>
<div class="fw-semibold"><span data-target="1,245">0</span></div>
</div>
<div class="text-end">
<span class="text-muted">Non-Role</span>
<div class="fw-semibold"><span data-target="1,110">0</span> <i class="ti ti-arrow-down"></i></div>
</div>
</div>



</div>
</div>
</div>
</div>






<div class="row">
<div class="col-xl-8 col-md-8 col-sm-8">
<div class="card">
<div class="card-body">
<div class="w-100" style="height: 240px;">
<canvas id="activeUsersChart"></canvas>
</div>

</div>
</div>
</div>

<div class="col-xl-4 col-md-4 col-sm-4">
<div class="card" style="height:273px;">
<div class="card-body">
<b>
<i data-lucide="xxx"></i>
Branch List
</b>


</div>
</div>

</div>
</div>


</div>

<?php include '../footer.php'; ?>