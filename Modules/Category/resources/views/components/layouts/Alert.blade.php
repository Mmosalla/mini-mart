
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="{{url('Panel/plugins/sweet_alert/sweetalert2.min.css')}}">

    <style>
        .toast-container {
            position: fixed;
            top: 25px;
            left: 25px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .toast {
            position: relative;
            min-width: 340px;
            max-width: 420px;
            padding: 16px 20px;
            border-radius: 16px;
            background: #1e293b;
            color: #f1f5f9;
            display: flex;
            align-items: center;
            gap: 14px;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.45);
            opacity: 0;
            transform: translateX(-120%) scale(0.85);
            animation: toastIn 0.55s cubic-bezier(0.22, 1.2, 0.36, 1) forwards;
        }

        .toast::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 5px;
            background: var(--accent, #6366f1);
            border-radius: 16px 0 0 16px;
        }

        @keyframes toastIn {
            0%   { opacity: 0; transform: translateX(-120%) scale(0.85); }
            60%  { transform: translateX(12px) scale(1.03); }
            100% { opacity: 1; transform: translateX(0) scale(1); }
        }

        .toast.hide {
            animation: toastOut 0.45s cubic-bezier(0.5, 0, 0.75, 0) forwards;
        }
        @keyframes toastOut {
            0%   { opacity: 1; transform: translateX(0) scale(1); }
            100% { opacity: 0; transform: translateX(-120%) scale(0.85); }
        }

        .toast-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
            background: var(--accent, #6366f1);
            box-shadow: 0 8px 18px var(--shadow, rgba(99, 102, 241, 0.45));
            animation: iconPop 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes iconPop {
            0%   { transform: scale(0) rotate(-90deg); }
            70%  { transform: scale(1.15) rotate(8deg); }
            100% { transform: scale(1) rotate(0); }
        }

        .toast-content { flex-grow: 1; }
        .toast-title {
            font-weight: 700;
            font-size: 14.5px;
            color: #fff;
            margin-bottom: 3px;
        }
        .toast-message {
            font-size: 12.5px;
            color: #94a3b8;
            line-height: 1.5;
        }

        .toast-close {
            background: transparent;
            border: none;
            color: #64748b;
            font-size: 20px;
            cursor: pointer;
            padding: 4px;
            line-height: 1;
            border-radius: 8px;
            transition: 0.25s;
        }
        .toast-close:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            transform: rotate(90deg);
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            right: 0;
            height: 3px;
            background: var(--accent, #6366f1);
            width: 100%;
            transform-origin: right;
            animation: progressBar linear forwards;
        }
        @keyframes progressBar {
            0%   { transform: scaleX(1); }
            100% { transform: scaleX(0); }
        }

        .toast.success { --accent: #10b981; --shadow: rgba(16, 185, 129, 0.5); }
        .toast.error   { --accent: #ef4444; --shadow: rgba(239, 68, 68, 0.5); }
        .toast.warning { --accent: #f59e0b; --shadow: rgba(245, 158, 11, 0.5); }
        .toast.info    { --accent: #3b82f6; --shadow: rgba(59, 130, 246, 0.5); }

        @media (max-width: 576px) {
            .toast-container { left: 12px; right: 12px; top: 12px; }
            .toast { min-width: auto; width: 100%; }
        }
    </style></head>
<body>

<div class="toast-container" id="toastContainer"></div>
<script src="{{ url('Panel/plugins/sweet_alert/sweetalert2.all.min.js') }}"></script>
    <script>
        function showToast(type, title, message, duration = 4000) {
            const container = document.getElementById('toastContainer');

            const icons = {
                success: 'uil-check',
                error:   'uil-times',
                warning: 'uil-exclamation',
                info:    'uil-info'
            };

            const toast = document.createElement('div');
            toast.className = `toast ${type}`;

            toast.innerHTML = `
        <div class="toast-icon">
            <i class="uil ${icons[type]}"></i>
        </div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
        <button class="toast-close">
            <i class="uil uil-times"></i>
        </button>
        <div class="toast-progress" style="animation-duration: ${duration}ms;"></div>
    `;

            container.appendChild(toast);

            const closeBtn = toast.querySelector('.toast-close');
            const timer = setTimeout(() => closeToast(toast), duration);
            closeBtn.addEventListener('click', () => {
                clearTimeout(timer);
                closeToast(toast);
            });
        }

        function closeToast(toast) {
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 450);
        }

    </script>
@stack('alert')
</body>
</html>
