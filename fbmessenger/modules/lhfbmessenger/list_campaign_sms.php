<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbmessenger/list_campaign_sms.tpl.php');

// -----------------------------
// FILTROS (GET)
// -----------------------------
$inputName     = isset($_GET['filter_name']) ? trim($_GET['filter_name']) : '';
$inputStatus   = isset($_GET['filter_status']) ? trim($_GET['filter_status']) : '';
$inputFromDate = isset($_GET['from_date']) ? trim($_GET['from_date']) : '';
$inputToDate   = isset($_GET['to_date']) ? trim($_GET['to_date']) : '';

// -----------------------------
// PAGINACIÓN
// -----------------------------
$itemsPerPage = 15; // 👈 ahora son 15 por página
$page = isset($_GET['page']) && is_numeric($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;

// Filtros base
$filter = ['sort' => 'id DESC'];
$countFilter = $filter;

// Filtro nombre (contains)
if ($inputName !== '') {
    $filter['filterlike']['name'] = $inputName;
    $countFilter['filterlike']['name'] = $inputName;
}

// Filtro estado exacto
if ($inputStatus !== '') {
    $filter['filter']['status'] = $inputStatus;
    $countFilter['filter']['status'] = $inputStatus;
}

// Filtro por rango de fecha programada (scheduled_at guarda timestamps)
if ($inputFromDate !== '') {
    $fromTs = strtotime($inputFromDate . ' 00:00:00');
    if ($fromTs !== false) {
        $filter['filtergte']['scheduled_at'] = $fromTs;
        $countFilter['filtergte']['scheduled_at'] = $fromTs;
    }
}
if ($inputToDate !== '') {
    $toTs = strtotime($inputToDate . ' 23:59:59');
    if ($toTs !== false) {
        $filter['filterlte']['scheduled_at'] = $toTs;
        $countFilter['filterlte']['scheduled_at'] = $toTs;
    }
}

// Contar total con filtros aplicados
$totalItems = erLhcoreClassModelSmsCampaign::getCount($countFilter);

// -----------------------------
// CALCULAR PÁGINAS
// -----------------------------
$totalPages = (int)ceil($totalItems / $itemsPerPage);
if ($page > $totalPages && $totalPages > 0) {
    $page = $totalPages;
}
$offset = ($page - 1) * $itemsPerPage;

// Añadir límite/offset
$filter['limit']  = $itemsPerPage;
$filter['offset'] = $offset;

// Obtener items
$items = erLhcoreClassModelSmsCampaign::getList($filter);

// -----------------------------
// MANEJO ELIMINACIÓN
// -----------------------------
if (isset($_POST['campaign_id_delete'])) {
    $campaignObj = erLhcoreClassModelSmsCampaign::fetch((int)$_POST['campaign_id_delete']);
    if ($campaignObj instanceof erLhcoreClassModelSmsCampaign) {
        $campaignObj->removeThis();
    }
    erLhcoreClassModule::redirect('fbmessenger/list_campaign_sms');
    exit;
}

// -----------------------------
// CONSTRUIR HTML DE PAGINACIÓN
// -----------------------------
$baseUrl = erLhcoreClassDesign::baseurl('fbmessenger/list_campaign_sms');
$queryParams = $_GET;
function buildPageUrl($baseUrl, $queryParams, $pageNum) {
    $qp = $queryParams;
    $qp['page'] = $pageNum;
    return $baseUrl . '?' . http_build_query($qp);
}

$paginationHtml = '';
if ($totalItems > $itemsPerPage) { // 👈 solo aparece si hay más de 15 registros
    $paginationHtml .= '
    <nav aria-label="Paginación de campañas">
        <ul class="pagination" style="
            display:flex;
            gap:8px;
            list-style:none;
            padding:0;
            margin:20px 0;
            justify-content:center;
        ">
    ';

    // Anterior
    if ($page > 1) {
        $paginationHtml .= '
        <li>
            <a href="' . htmlspecialchars(buildPageUrl($baseUrl, $queryParams, $page - 1)) . '" 
               style="padding:6px 12px;border:1px solid #ccc;border-radius:6px;color:#007bff;text-decoration:none;">
               &laquo; Anterior
            </a>
        </li>';
    } else {
        $paginationHtml .= '
        <li>
            <span style="padding:6px 12px;border:1px solid #ddd;border-radius:6px;color:#aaa;background:#f9f9f9;cursor:not-allowed;">
                &laquo; Anterior
            </span>
        </li>';
    }

    // Páginas
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            $paginationHtml .= '
            <li>
                <span style="padding:6px 12px;border-radius:6px;background:#007bff;color:#fff;font-weight:bold;">
                    ' . $i . '
                </span>
            </li>';
        } else {
            $paginationHtml .= '
            <li>
                <a href="' . htmlspecialchars(buildPageUrl($baseUrl, $queryParams, $i)) . '" 
                   style="padding:6px 12px;border:1px solid #ccc;border-radius:6px;color:#007bff;text-decoration:none;">
                   ' . $i . '
                </a>
            </li>';
        }
    }

    // Siguiente
    if ($page < $totalPages) {
        $paginationHtml .= '
        <li>
            <a href="' . htmlspecialchars(buildPageUrl($baseUrl, $queryParams, $page + 1)) . '" 
               style="padding:6px 12px;border:1px solid #ccc;border-radius:6px;color:#007bff;text-decoration:none;">
               Siguiente &raquo;
            </a>
        </li>';
    } else {
        $paginationHtml .= '
        <li>
            <span style="padding:6px 12px;border:1px solid #ddd;border-radius:6px;color:#aaa;background:#f9f9f9;cursor:not-allowed;">
                Siguiente &raquo;
            </span>
        </li>';
    }

    $paginationHtml .= '</ul></nav>';
}

// -----------------------------
// PASAR VARIABLES A LA VISTA
// -----------------------------
$tpl->set('items', $items);
$tpl->set('totalItems', $totalItems);
$tpl->set('totalPages', $totalPages);
$tpl->set('currentPage', $page);
$tpl->set('paginationHtml', $paginationHtml);
$tpl->set('inputName', $inputName);
$tpl->set('inputStatus', $inputStatus);
$tpl->set('inputFromDate', $inputFromDate);
$tpl->set('inputToDate', $inputToDate);

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array('url' => erLhcoreClassDesign::baseurl('fbmessenger/list_campaign_sms'), 'title' => 'Campañas SMS'),
);
