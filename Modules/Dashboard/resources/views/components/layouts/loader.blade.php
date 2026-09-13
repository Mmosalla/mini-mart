<style>
    .loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;

        display: flex;
        align-items: center;
        justify-content: center;

        background: rgba(255, 255, 255, 0.45);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);

        z-index: 999999;

        /* اجازه نمی‌دهد کلیک به عناصر زیر برسد */
        pointer-events: all;
    }

    .loader-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        min-width: 180px;
        padding: 25px 35px;

        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;

        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);

        color: #555;
        font-size: 14px;
    }

    .loader-box .spinner-border {
        width: 2.5rem;
        height: 2.5rem;
        margin-bottom: 12px;
    }
</style>

<div wire:loading class="loader-overlay">
    <div class="loader-box">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">در حال بارگذاری...</span>
        </div>

        <span>در حال بارگذاری...</span>
    </div>
</div>
