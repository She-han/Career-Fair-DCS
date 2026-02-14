import introImage from '../../../images/0.jpg';

export default function Introduction() {
    return (
        <section className="py-16 transition-colors duration-500 bg-gray-50 dark:bg-gray-800">
            <div className="container px-4 mx-auto sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white border border-gray-200 shadow-sm dark:border-gray-700 dark:bg-gray-800 rounded-xl">
                    <div className="grid grid-cols-1 gap-0 lg:grid-cols-2">
                        {/* Image Section */}
                        <div className="relative h-64 overflow-hidden lg:h-auto">
                            <img 
                                src={introImage} 
                                alt="Career Fair 2026" 
                                className="object-cover w-full h-full"
                            />
                            <div className="absolute inset-0 bg-gradient-to-r from-blue-900/20 to-transparent" />
                        </div>

                        {/* Content Section */}
                        <div className="p-8 lg:p-12">
                            {/* Title */}
                            <div className="mb-6">
                    <h2 className="mb-4 text-4xl font-bold text-transparent md:text-5xl bg-gradient-to-r from-blue-700 via-purple-600 to-cyan-600 dark:from-blue-300 dark:via-purple-400 dark:to-cyan-400 bg-clip-text drop-shadow-lg">
                        Career Fair Memories
                    </h2>
                                <div className="w-20 h-1 bg-blue-600 rounded-full" />
                            </div>

                            {/* Main Description */}
                            <div className="mb-8 space-y-4">
                                <p className="text-base leading-relaxed text-gray-700 dark:text-gray-300">
                                    The Department of Computer Science, with the support of the Computer Science
                                    Community of the Faculty of Science, University of Ruhuna, is organizing the Career Fair on
                                    <strong className="font-semibold text-gray-900 dark:text-white"> 31st March 2026</strong>. This event serves as a platform for companies to identify and recruit
                                    talented candidates to meet their future needs. Interview sessions to be held online.
                                </p>
                            </div>

                            {/* Target Audience */}
                            <div className="p-6 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-900/50 dark:border-gray-700">
                                <h3 className="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                                    Primary Audience
                                </h3>
                                <ul className="space-y-3">
                                    <li className="flex items-start">
                                        <svg className="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                        </svg>
                                        <span className="text-sm text-gray-700 dark:text-gray-300">
                                            Bachelor of Computer Science undergraduates seeking six-month or
                                            one-year internships to fulfill degree requirements.
                                        </span>
                                    </li>
                                    <li className="flex items-start">
                                        <svg className="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                        </svg>
                                        <span className="text-sm text-gray-700 dark:text-gray-300">
                                            Graduates who have completed internships and are seeking permanent
                                            positions in the industry.
                                        </span>
                                    </li>
                                    <li className="flex items-start">
                                        <svg className="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                        </svg>
                                        <span className="text-sm text-gray-700 dark:text-gray-300">
                                            Bachelor of Science (special in Computer Science) students completing their
                                            degrees and looking for permanent positions.
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
