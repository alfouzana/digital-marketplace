<?php

function approval_lang($status)
{
    if ($status === \Mtvs\EloquentApproval\ApprovalStatuses::PENDING) {
        return __('Pending');
    }

    if ($status === \Mtvs\EloquentApproval\ApprovalStatuses::APPROVED) {
        return __('Approved');
    }

    if ($status === \Mtvs\EloquentApproval\ApprovalStatuses::REJECTED) {
        return __('Rejected');
    }
}


function approval_context($status)
{
    if ($status === \Mtvs\EloquentApproval\ApprovalStatuses::PENDING) {
        return 'warning';
    }

    if ($status === \Mtvs\EloquentApproval\ApprovalStatuses::APPROVED) {
        return 'success';
    }

    if ($status === \Mtvs\EloquentApproval\ApprovalStatuses::REJECTED) {
        return 'danger';
    }
}
