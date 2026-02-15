import { useState, useEffect } from 'react';
import { XMarkIcon, CheckCircleIcon, XCircleIcon } from '@heroicons/react/24/outline';

export default function FlashMessages({ flash }) {
    const [showSuccess, setShowSuccess] = useState(!!flash?.success);
    const [showError, setShowError] = useState(!!flash?.error);

    useEffect(() => {
        if (flash?.success) {
            setShowSuccess(true);
            const timer = setTimeout(() => setShowSuccess(false), 5000);
            return () => clearTimeout(timer);
        }
    }, [flash?.success]);

    useEffect(() => {
        if (flash?.error) {
            setShowError(true);
            const timer = setTimeout(() => setShowError(false), 5000);
            return () => clearTimeout(timer);
        }
    }, [flash?.error]);

    return (
        <>
            {showSuccess && flash?.success && (
                <div className="fixed top-20 right-4 z-50 animate-slideIn max-w-md">
                    <div className="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-lg p-4 shadow-lg">
                        <div className="flex items-center justify-between">
                            <div className="flex items-center gap-3">
                                <CheckCircleIcon className="w-6 h-6 text-green-500" />
                                <p className="text-green-800 dark:text-green-200 font-medium">{flash.success}</p>
                            </div>
                            <button onClick={() => setShowSuccess(false)} className="text-green-600 hover:text-green-800 dark:text-green-400">
                                <XMarkIcon className="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {showError && flash?.error && (
                <div className="fixed top-20 right-4 z-50 animate-slideIn max-w-md">
                    <div className="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg p-4 shadow-lg">
                        <div className="flex items-center justify-between">
                            <div className="flex items-center gap-3">
                                <XCircleIcon className="w-6 h-6 text-red-500" />
                                <p className="text-red-800 dark:text-red-200 font-medium">{flash.error}</p>
                            </div>
                            <button onClick={() => setShowError(false)} className="text-red-600 hover:text-red-800 dark:text-red-400">
                                <XMarkIcon className="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
}
