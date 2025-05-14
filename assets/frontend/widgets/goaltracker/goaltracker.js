(function($) {
    'use strict';

    var BriklyGoalTracker = {
        init: function() {
            var self = this;

            // Ensure Lottie library is loaded
            this.ensureLottieLibrary().then(function() {
                // For non-Elementor frontend
                if (typeof window.elementorFrontend === 'undefined') {
                    self.initLottie();
                    return;
                }

                // For Elementor frontend
                // Register immediately if already initialized
                elementorFrontend.hooks.addAction('frontend/element_ready/brikly_goal_tracker.default', function($element) {
                    self.initLottie($element);
                });

                // Handle events like changes in the editor preview
                self.bindEvents();
            }).catch(function(error) {
                console.error('Goal Tracker: Failed to load Lottie library:', error);
            });
        },

        ensureLottieLibrary: function() {
            return new Promise(function(resolve, reject) {
                if (typeof lottie !== 'undefined') {
                    resolve();
                    return;
                }

                // Try to load Lottie library if not already loaded
                var script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js';
                script.async = true;
                script.onload = function() {
                    if (typeof lottie !== 'undefined') {
                        resolve();
                    } else {
                        reject(new Error('Lottie library failed to initialize'));
                    }
                };
                script.onerror = function() {
                    reject(new Error('Failed to load Lottie library'));
                };
                document.body.appendChild(script);
            });
        },

        initLottie: function($scope) {
            var $widgets = $scope ? $scope.find('.goal-tracker-widget') : $('.goal-tracker-widget');
            
            if (!$widgets.length) {
                console.warn('Goal Tracker: No widgets found');
                return;
            }

            $widgets.each(function() {
                var $widget = $(this);
                var $lottieContainer = $widget.find('.goal-tracker-lottie');
                
                if (!$lottieContainer.length) {
                    console.warn('Goal Tracker: Lottie container not found in widget');
                    return;
                }

                // Clean up existing animation if any
                var existingAnimation = $lottieContainer.data('lottie-instance');
                if (existingAnimation) {
                    existingAnimation.destroy();
                    $lottieContainer.removeData('lottie-instance');
                }

                var lottieUrl = $lottieContainer.data('lottie-url');
                var animationType = $lottieContainer.data('animation-type');
                var animationDirection = $lottieContainer.data('animation-direction');
                var progress = parseFloat($lottieContainer.data('progress')) || 0;

                if (!lottieUrl) {
                    console.warn('Goal Tracker: No Lottie URL provided');
                    return;
                }

                try {
                    var animation = lottie.loadAnimation({
                        container: $lottieContainer[0],
                        renderer: 'svg',
                        loop: animationType === 'loop',
                        autoplay: false,
                        path: lottieUrl,
                        rendererSettings: {
                            progressiveLoad: true,
                            preserveAspectRatio: 'xMidYMid meet'
                        }
                    });

                    animation.addEventListener('DOMLoaded', function() {
                        console.log('Goal Tracker: Animation DOM elements created');
                        
                        // Set direction
                        if (animationDirection === 'reverse') {
                            animation.setDirection(-1);
                        }

                        // Handle progress-based animation control
                        if (progress >= 100) {
                            animation.goToAndPlay(animation.totalFrames - 1, true);
                        } else if (progress > 0) {
                            var frame = Math.floor((progress / 100) * animation.totalFrames);
                            animation.goToAndStop(frame, true);
                        } else {
                            animation.play();
                        }
                    });

                    animation.addEventListener('data_ready', function() {
                        console.log('Goal Tracker: Animation data loaded successfully');
                    });

                    animation.addEventListener('data_failed', function() {
                        console.error('Goal Tracker: Failed to load animation data');
                    });

                    // Store animation instance
                    $lottieContainer.data('lottie-instance', animation);

                } catch (error) {
                    console.error('Goal Tracker: Error initializing Lottie:', error);
                }
            });
        },

        bindEvents: function() {
            var self = this;
            
            if (window.elementorFrontend && window.elementorFrontend.isEditMode()) {
                // Handle Elementor editor preview updates
                elementor.channels.editor.on('change', function(view) {
                    var $widget = view.$el.find('.goal-tracker-widget');
                    if ($widget.length) {
                        self.initLottie($widget.parent());
                    }
                });

                // Handle widget panel changes
                elementor.channels.editor.on('panel:switch', function(panel) {
                    var $widget = panel.$el.find('.goal-tracker-widget');
                    if ($widget.length) {
                        self.initLottie($widget.parent());
                    }
                });
            }
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        BriklyGoalTracker.init();
    });

})(jQuery);
