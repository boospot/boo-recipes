# Changelog

All notable changes to the Boo Recipes plugin will be documented in this file.

## [2.5.0] - 2024-12-19

### 🔒 Security Improvements
- **Fixed Information Disclosure**: Removed nonce values from error messages in admin AJAX handlers
- **Enhanced Input Validation**: Added proper type checking and validation for all user inputs
- **Improved Sanitization**: Enhanced sanitization of GET/POST parameters with proper type checking
- **XSS Prevention**: Added proper escaping for all output in templates and forms
- **Nonce Verification**: Added missing nonce verification for AJAX endpoints

### 🚀 PHP 8+ Compatibility
- **PHP Version Requirement**: Updated minimum PHP requirement to 8.0
- **Type Safety**: Added proper type checking throughout the codebase
- **Null Safety**: Improved handling of potentially null values
- **Array Access**: Enhanced array access with proper validation
- **Class Instance Checks**: Updated to use `instanceof` instead of `get_class()`

### 📦 Dependency Updates
- **Meta Box**: Updated from 5.3.8 to 5.10.11 (latest stable)
- **Composer Installers**: Updated from 1.10.0 to 2.3.0
- **Boo Settings Helper**: Updated to stable version 5.3
- **WPTRT Admin Notices**: Updated to 1.0.4

### 🛠️ Code Quality Improvements
- **Input Validation**: Added comprehensive input validation for all user inputs
- **Error Handling**: Improved error handling and user feedback
- **Code Standards**: Enhanced code following WordPress coding standards
- **Security Best Practices**: Implemented WordPress security best practices

### 🔧 Technical Improvements
- **Composer Configuration**: Updated composer.json with proper metadata and requirements
- **Autoloader Optimization**: Enabled optimized autoloader for better performance
- **Package Stability**: Set minimum stability to stable for production use
- **PHP Version Check**: Added runtime PHP version compatibility check

### 🐛 Bug Fixes
- **Search Form Security**: Fixed potential XSS vulnerabilities in search forms
- **AJAX Security**: Enhanced security for all AJAX endpoints
- **Template Security**: Improved security in all template files
- **Helper Functions**: Fixed security issues in helper functions

### 📋 Breaking Changes
- **PHP Requirement**: Now requires PHP 8.0 or higher
- **WordPress Requirement**: Now requires WordPress 5.0 or higher

### 🔄 Migration Notes
- Users with PHP versions below 8.0 will see a compatibility notice
- All existing functionality remains the same
- No database changes required
- No configuration changes required

## [2.4.1] - Previous Version
- Initial stable release with basic recipe functionality 