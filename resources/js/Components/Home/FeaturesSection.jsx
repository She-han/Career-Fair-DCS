import { motion } from 'framer-motion';
import { BriefcaseIcon, AcademicCapIcon, ShieldCheckIcon } from '@heroicons/react/24/outline';

const features = [
    {
        title: 'For Companies',
        description: 'Access to talented students, streamlined CV review process, and efficient candidate selection.',
        icon: BriefcaseIcon,
        gradient: 'from-blue-500 via-purple-500 to-cyan-500',
        bgGradient: 'from-white via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-950 dark:to-purple-950',
        border: 'border-blue-200 dark:border-blue-800 hover:border-blue-400 dark:hover:border-blue-600',
    },
    {
        title: 'For Students',
        description: 'Showcase your skills, upload your CV, and connect with potential employers seamlessly.',
        icon: AcademicCapIcon,
        gradient: 'from-purple-500 via-cyan-500 to-blue-500',
        bgGradient: 'from-white via-purple-50 to-cyan-50 dark:from-gray-900 dark:via-purple-950 dark:to-cyan-950',
        border: 'border-purple-200 dark:border-purple-800 hover:border-purple-400 dark:hover:border-purple-600',
    },
    {
        title: 'Secure & Efficient',
        description: 'Enterprise-grade security, role-based access control, and streamlined processes.',
        icon: ShieldCheckIcon,
        gradient: 'from-cyan-500 via-blue-500 to-purple-500',
       bgGradient: 'from-white via-cyan-50 to-blue-50 dark:from-gray-900 dark:via-cyan-950 dark:to-blue-950',
        border: 'border-cyan-200 dark:border-cyan-800 hover:border-cyan-400 dark:hover:border-cyan-600',
    },
];

export default function FeaturesSection() {
    return (
        <section className="py-20 bg-gradient-to-br from-gray-50 via-purple-50 to-blue-50 dark:from-gray-800 dark:via-purple-900/20 dark:to-blue-900/20 transition-colors duration-500">
            <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                <motion.div
                    initial={{ opacity: 0, y: -50 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    className="text-center mb-16"
                >
                    <h2 className="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-blue-700 via-purple-600 to-cyan-600 dark:from-blue-300 dark:via-purple-400 dark:to-cyan-400 bg-clip-text text-transparent drop-shadow-lg">
                        Why Choose Career Fair DCS?
                    </h2>
                    <p className="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto">
                        A modern platform connecting talent with opportunity through innovation and excellence
                    </p>
                </motion.div>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {features.map((feature, index) => (
                        <motion.div
                            key={feature.title}
                            initial={{ opacity: 0, y: 50 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ delay: index * 0.1 }}
                            whileHover={{ y: -12, scale: 1.02 }}
                            className={`group relative bg-gradient-to-br ${feature.bgGradient} rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 border-2 ${feature.border} overflow-hidden`}
                        >
                            {/* Background Overlay */}
                            <motion.div
                                initial={{ opacity: 0 }}
                                whileHover={{ opacity: 1 }}
                                className={`absolute inset-0 bg-gradient-to-br ${feature.gradient} opacity-0 group-hover:opacity-10 transition-opacity duration-500`}
                            />

                            {/* Icon */}
                            <motion.div
                                whileHover={{ rotate: 6, scale: 1.1 }}
                                className={`w-16 h-16 bg-gradient-to-br ${feature.gradient} rounded-2xl flex items-center justify-center mb-6 shadow-lg relative z-10`}
                            >
                                <feature.icon className="w-8 h-8 text-white" />
                            </motion.div>

                            {/* Content */}
                            <motion.h3
                                whileHover={{ x: 8 }}
                                className="text-2xl font-bold mb-3 text-gray-900 dark:text-gray-100 relative z-10"
                            >
                                {feature.title}
                            </motion.h3>
                            <p className="text-gray-600 dark:text-gray-400 relative z-10 leading-relaxed">
                                {feature.description}
                            </p>
                        </motion.div>
                    ))}
                </div>
            </div>
        </section>
    );
}
